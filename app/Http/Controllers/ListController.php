<?php

namespace App\Http\Controllers;

use App\Models\AnimeFavorite;
use App\Models\AnimeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ListController extends Controller
{
    public function index()
    {
        $api = new ApiController();
        $genres = $api->genre();
        $get_top_anime = $api->TopAnime(page: 1);
        $image = '';

        if ($get_top_anime) {
            foreach (array_slice($get_top_anime->data, 1, 6) as $top_anime) {
                $image .= $top_anime->entry->mal_id . ',' . $api->AnimeDetail($top_anime->entry->mal_id)->data->images->webp->large_image_url . '#';
            }
        }
        return view('home')
            ->with([
                'title' => 'home',
                'genres' => $genres->data,
                'forbidden_genre' => $api->ForbiddenGenre(),
                'all_anime' => $api->GetAnime(url: 'https://api.jikan.moe/v4/top/anime?filter=bypopularity', page: 1, limit: 6)->data,
                'top_anime' => $get_top_anime ? array_slice($get_top_anime->data, 1, 6) : [],
                'top_image' => explode('#', $image),
                'this_season_anime' => $api->GetAnime(url: 'https://api.jikan.moe/v4/seasons/now?', page: 1, limit: 6)->data,
                'next_season_anime' => $api->GetAnime(url: 'https://api.jikan.moe/v4/seasons/upcoming?', page: 1, limit: 6)->data,
            ]);
    }

    public function search(Request $request)
    {
        $genre = '';
        $api = new ApiController();
        $data = $api->Search(str_replace(' ', '%20', $request->search), $request->genre);
        $output = '';

        foreach ($data->data as $key => $value) {
            foreach ($value->genres as $item) {
                $genre .= $item->name . '#';
            }

            if (!array_intersect(explode('#', $genre), $api->ForbiddenGenre())) {
                if ($value->type == 'TV' || $value->type == 'Movie') {
                    if ($value->images->webp->image_url != 'https://cdn.myanimelist.net/img/sp/icon/apple-touch-icon-256.png') {
                        $output .= '
                        <div class="col-lg-2 col-md-3 col-4 mb-3">
                            <a href="' . url('anime/' . $value->mal_id . '/' . str_replace(' ', '_', $value->title)) . '" onclick="load()" class="box-anime" style="overflow: hidden">
                                <img src="' . $value->images->webp->image_url . '" class="img-fluid mb-2">
                                <div class="text-gray fw-bold fs-small text-truncate">' . $value->title . '</div>
                            </a>
                        </div>
                        ';
                    }
                }
            }
        }

        return response()->json([
            'status' => 200,
            'search' => $request->search,
            'data' => $output
        ]);
    }

    public function AnimeList()
    {
        $api = new ApiController();
        $genres = $api->genre();
        $get_anime_list = $api->GetAnime(url: 'https://api.jikan.moe/v4/top/anime?filter=bypopularity', page: request('page'));

        return view('anime')
            ->with([
                'genres' => $genres ? $genres->data : [],
                'forbidden_genre' => $api->ForbiddenGenre(),
                'title' => 'ALL TIME POPULAR',
                'data' => $get_anime_list->data,
                'pagination' => $api->Pagination(request('page'), $get_anime_list)[0]
            ]);
    }

    public function Anime($data)
    {
        $api = new ApiController();
        $genres = $api->genre();

        if ($data == 'top') {
            $image = '';
            $get_top_anime = $api->TopAnime(request('page'));
            foreach ($get_top_anime->data as $top_anime) {
                $image .= $top_anime->entry->mal_id . ',' . $api->AnimeDetail($top_anime->entry->mal_id)->data->images->webp->large_image_url . '#';
            }

            $title = "TOP ANIME";
            $data = $get_top_anime->data;
            $pagination = $api->Pagination(request('page'), $get_top_anime)[0];

            return view('anime')
                ->with([
                    'genres' => $genres ? $genres->data : [],
                    'forbidden_genre' => $api->ForbiddenGenre(),
                    'title' => $title,
                    'data' => $data,
                    'image' => explode('#', $image),
                    'pagination' => $pagination
                ]);
        } elseif ($data == 'this-season') {
            $title = "POPULAR THIS SEASON";
            $get_this_season = $api->GetAnime(url: 'https://api.jikan.moe/v4/seasons/now?', page: request('page'));
            $data = $get_this_season->data;
            $pagination = $api->Pagination(request('page'), $get_this_season)[0];
        } elseif ($data == 'next-season') {
            $title = "POPULAR NEXT SEASON";
            $get_next_season = $api->GetAnime(url: 'https://api.jikan.moe/v4/seasons/upcoming?', page: request('page'));
            $data = $get_next_season->data;
            $pagination = $api->Pagination(request('page'), $get_next_season)[0];
        }

        return view('anime')
            ->with([
                'genres' => $genres ? $genres->data : [],
                'forbidden_genre' => $api->ForbiddenGenre(),
                'title' => $title,
                'data' => $data,
                'pagination' => $pagination
            ]);
    }

    public function Genre($id, $genre)
    {
        $api = new ApiController();
        $genres = $api->genre();
        $get_anime_filter_genre = $api->FilterGenre($id, search: request('search') ?: '', page: request('page'));

        if (!in_array($id, $api->ForbiddenGenre())) {
            return view('genres')
                ->with([
                    'title' => 'genre',
                    'genres' => $genres ? $genres->data : [],
                    'forbidden_genre' => $api->ForbiddenGenre(),
                    'this_genre' => $genre,
                    'filter_genre' => $get_anime_filter_genre->data,
                    'pagination' => $api->Pagination(request('page'), $get_anime_filter_genre)[0]
                ]);
        } else {
            abort(404);
        }
    }

    public function Detail($id, $title)
    {
        $api = new ApiController();

        // Forbidden Genre
        $genre = '';
        foreach ($api->AnimeDetail($id)->data->genres as $key => $value) {
            $genre .= $value->name . '#';
        }

        $list = '';
        $fav = '';
        if (Auth::check()) {
            $list = AnimeList::where(['user_id' => auth()->user()->id, 'anime_id' => $api->AnimeDetail($id)->data->mal_id])->first();
            $fav = AnimeFavorite::where(['user_id' => auth()->user()->id, 'anime_id' => $api->AnimeDetail($id)->data->mal_id])->first();
        }

        if (!array_intersect(explode('#', $genre), $api->ForbiddenGenre())) {
            $char = $api->AnimeCharacter($id)->data;
            return view('detail.overview')
                ->with([
                    'title' => 'detail',
                    'list' => $list,
                    'fav' => $fav,
                    'detail' => $api->AnimeDetail($id)->data,
                    'characters' => isset($char) ? array_slice($char, 0, 6) : null,
                    'staff' => array_slice($api->AnimeStaff($id)->data, 0, 4),
                    'statistics' => $api->AnimeStatistics($id)->data,
                    'recomended' => array_slice($api->Recomended($id)->data, 0, 6),
                    'videos' => array_slice($api->Watch($id)->data->episodes, 0, 6),
                ]);
        } else {
            return abort(404);
        }
    }

    public function RelationImage(Request $request)
    {
        $api = new ApiController();
        $output = '';

        foreach ($api->AnimeRelations($request->id)->data as $key => $rel) {
            if ($rel->relation != 'Adaptation') {
                foreach ($rel->entry as $item) {
                    $output .= '
                    <div class="me-2" title="' . $item->name . '" style="width: 120px">
                        <a href="' . url('anime/' . $item->mal_id . '/' . str_replace(' ', '_', $item->name)) . '" onclick="load()" class="box-anime bg-white" style="overflow: hidden">
                            <img src="' . $api->AnimeDetail($item->mal_id)->data->images->webp->large_image_url . '" class="img-fluid mb-2" style="height: 150px; object-fit:cover">
                            <div class="text-gray fw-bold fs-small text-truncate" style="width: 120px">' . $item->name . '</div>
                        </a>
                    </div>
                    ';
                }
            }
        }

        return response()->json([
            'status' => 200,
            'data' => $output
        ]);
    }

    public function DetailMenu($id, $title, $menu)
    {
        $api = new ApiController();
        $list = '';
        $fav = '';
        if (Auth::check()) {
            $list = AnimeList::where(['user_id' => auth()->user()->id, 'anime_id' => $api->AnimeDetail($id)->data->mal_id])->first();
            $fav = AnimeFavorite::where(['user_id' => auth()->user()->id, 'anime_id' => $api->AnimeDetail($id)->data->mal_id])->first();
        }

        // Forbidden Genre
        $genre = '';
        foreach ($api->AnimeDetail($id)->data->genres as $key => $value) {
            $genre .= $value->name . '#';
        }

        if (!array_intersect(explode('#', $genre), $api->ForbiddenGenre())) {
            if ($menu == 'watch') {
                $get_anime_videos = $api->AnimeVideos($id, (request('page')) ?: 1);
                return view('detail.watch')
                    ->with([
                        'title' => 'watch',
                        'list' => $list,
                        'fav' => $fav,
                        'detail' => $api->AnimeDetail($id)->data,
                        'videos' => $get_anime_videos->data,
                        'pagination' => $api->Pagination(request('page'), $get_anime_videos)[0]
                    ]);
            } else if ($menu == 'character') {
                return view('detail.character')
                    ->with([
                        'title' => 'character',
                        'list' => $list,
                        'fav' => $fav,
                        'detail' => $api->AnimeDetail($id)->data,
                        'characters' => $api->AnimeCharacter($id)->data,
                    ]);
            } else if ($menu == 'staff') {
                return view('detail.staff')
                    ->with([
                        'title' => 'staff',
                        'list' => $list,
                        'fav' => $fav,
                        'detail' => $api->AnimeDetail($id)->data,
                        'staff' => $api->AnimeStaff($id)->data,
                    ]);
            }
        } else {
            abort(404);
        }
    }

    public function AddList(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = explode('#', $request->status);

        $unique_list = AnimeList::where(['user_id' => $user_id, 'anime_id' => $data[1]]);

        if ($data[0] != "Dropped") {
            if (count($unique_list->get())) {
                $model_list = $unique_list->first();
                $model_list->user_id = $user_id;
                $model_list->anime_id = $data[1];
                $model_list->title = $data[2];
                $model_list->img = $data[3];
                $model_list->status = $data[0];
                $model_list->update();
            } else {
                $model_list = new AnimeList();
                $model_list->user_id = $user_id;
                $model_list->anime_id = $data[1];
                $model_list->title = $data[2];
                $model_list->img = $data[3];
                $model_list->status = $data[0];
                $model_list->save();
            }
        } else {
            $unique_list->delete();
            return response()->json([
                'status' => $data[0],
            ]);
        }

        if ($data[0] == "Completed") {
            $output = '<span class="fs-xsmall text-primary text-glow-blue"><i class="fa-solid fa-circle-check"></i></span> ';
        } elseif ($data[0] == "Watching") {
            $output = '<span class="fs-xsmall text-success text-glow-green"><i class="fa-solid fa-play"></i></span> ';
        } elseif ($data[0] == "Plan to Watch") {
            $output = '<span class="fs-xsmall text-warning text-glow-yellow"><i class="fa-solid fa-list-check"></i></span> ';
        } elseif ($data[0] == "Rewatching") {
            $output = '<span class="fs-xsmall text-success text-glow-green"><i class="fa-solid fa-repeat"></i></span> ';
        } elseif ($data[0] == "Paused") {
            $output = '<span class="fs-xsmall text-danger text-glow-red"><i class="fa-solid fa-pause"></i></span> ';
        }

        // return Redirect::back()->with('added', 'List Addedd');
        return response()->json([
            'status' => $data[0],
            'data' => $output,
        ]);
    }

    public function AddFavorite(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = explode('#', $request->data);

        $unique_list = AnimeFavorite::where(['user_id' => $user_id, 'anime_id' => $data[1]]);

        if (count($unique_list->get())) {
            $unique_list->delete();

            return response()->json([
                'status' => 400,
            ]);
        } else {
            $model_list = new AnimeFavorite();
            $model_list->user_id = $user_id;
            $model_list->anime_id = $data[1];
            $model_list->title = $data[2];
            $model_list->img = $data[3];
            $model_list->genre = $data[0];
            $model_list->save();

            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
