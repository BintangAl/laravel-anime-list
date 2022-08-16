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
        $image = '';

        foreach (array_slice(json_decode($api->TopAnime(1))->data, 1, 6) as $key => $value) {
            $image .= $value->entry->mal_id . ',' . json_decode($api->AnimeDetail($value->entry->mal_id))->data->images->webp->large_image_url . '#';
        }

        return view('home')
            ->with([
                'title' => 'home',
                'genres' => json_decode($api->genre())->data,
                'forbidden_genre' => $api->ForbiddenGenre(),
                'all_anime' => array_slice(json_decode($api->AllAnime(1))->data, 0, 6),
                'top_anime' => array_slice(json_decode($api->TopAnime(1))->data, 1, 6),
                'top_image' => explode('#', $image),
                'this_season_anime' => json_decode($api->ThisSeason(1))->data,
                'next_season_anime' => json_decode($api->NextSeason(1))->data,
            ]);
    }

    public function search(Request $request)
    {
        $genre = '';
        $api = new ApiController();
        $data = json_decode($api->Search(str_replace(' ', '%20', $request->search), $request->genres));
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

        return view('anime')
            ->with([
                'genres' => json_decode($api->genre())->data,
                'forbidden_genre' => $api->ForbiddenGenre(),
                'title' => 'ALL TIME POPULAR',
                'data' => json_decode($api->AllAnime(request('page')))->data,
                'pagination' => $api->Pagination(request('page'), $api->AllAnime(1))[0]
            ]);
    }

    public function Anime($data)
    {
        $api = new ApiController();

        if ($data == 'top') {
            $image = '';
            foreach (json_decode($api->TopAnime('page'))->data as $key => $value) {
                $image .= $value->entry->mal_id . ',' . json_decode($api->AnimeDetail($value->entry->mal_id))->data->images->webp->large_image_url . '#';
            }

            $title = "TOP ANIME";
            $data = json_decode($api->TopAnime(request('page')))->data;
            $pagination = $api->Pagination(request('page'), $api->TopAnime(1))[0];

            return view('anime')
                ->with([
                    'genres' => json_decode($api->genre())->data,
                    'forbidden_genre' => $api->ForbiddenGenre(),
                    'title' => $title,
                    'data' => $data,
                    'image' => explode('#', $image),
                    'pagination' => $pagination
                ]);
        } elseif ($data == 'this-season') {
            $title = "POPULAR THIS SEASON";
            $data = json_decode($api->ThisSeason(request('page')))->data;
            $pagination = $api->Pagination(request('page'), $api->ThisSeason(1))[0];
        } elseif ($data == 'next-season') {
            $title = "POPULAR NEXT SEASON";
            $data = json_decode($api->NextSeason(request('page')))->data;
            $pagination = $api->Pagination(request('page'), $api->NextSeason(1))[0];
        }

        return view('anime')
            ->with([
                'genres' => json_decode($api->genre())->data,
                'forbidden_genre' => $api->ForbiddenGenre(),
                'title' => $title,
                'data' => $data,
                'pagination' => $pagination
            ]);
    }

    public function Genre($id, $genre)
    {
        $api = new ApiController();

        if (!in_array($id, $api->ForbiddenGenre())) {
            return view('genres')
                ->with([
                    'title' => 'genre',
                    'genres' => json_decode($api->genre())->data,
                    'forbidden_genre' => $api->ForbiddenGenre(),
                    'this_genre' => $genre,
                    'filter_genre' => json_decode($api->FilterGenre($id))->data,
                    'pagination' => $api->Pagination(request('page'), $api->FilterGenre(1))[0]
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
        foreach (json_decode($api->AnimeDetail($id))->data->genres as $key => $value) {
            $genre .= $value->name . '#';
        }

        $list = '';
        $fav = '';
        if (Auth::check()) {
            $list = AnimeList::where(['user_id' => auth()->user()->id, 'anime_id' => json_decode($api->AnimeDetail($id))->data->mal_id])->first();
            $fav = AnimeFavorite::where(['user_id' => auth()->user()->id, 'anime_id' => json_decode($api->AnimeDetail($id))->data->mal_id])->first();
        }

        if (!array_intersect(explode('#', $genre), $api->ForbiddenGenre())) {
            $char = json_decode($api->AnimeCharacter($id))->data;
            return view('detail.overview')
                ->with([
                    'title' => 'detail',
                    'list' => $list,
                    'fav' => $fav,
                    'detail' => json_decode($api->AnimeDetail($id))->data,
                    'characters' => isset($char) ? array_slice($char, 0, 6) : null,
                    'staff' => array_slice(json_decode($api->AnimeStaff($id))->data, 0, 4),
                    'statistics' => json_decode($api->AnimeStatistics($id))->data,
                    'recomended' => array_slice(json_decode($api->recomended($id))->data, 0, 6),
                    'videos' => array_slice(json_decode($api->Watch($id))->data->episodes, 0, 6),
                ]);
        } else {
            return abort(404);
        }
    }

    public function RelationImage(Request $request)
    {
        $api = new ApiController();
        $output = '';

        foreach (json_decode($api->AnimeRelations($request->id))->data as $key => $rel) {
            if ($rel->relation != 'Adaptation') {
                foreach ($rel->entry as $item) {
                    $output .= '
                    <div class="me-2" title="' . $item->name . '" style="width: 120px">
                        <a href="' . url('anime/' . $item->mal_id . '/' . str_replace(' ', '_', $item->name)) . '" onclick="load()" class="box-anime bg-white" style="overflow: hidden">
                            <img src="' . json_decode($api->AnimeDetail($item->mal_id))->data->images->webp->large_image_url . '" class="img-fluid mb-2" style="height: 150px; object-fit:cover">
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
            $list = AnimeList::where(['user_id' => auth()->user()->id, 'anime_id' => json_decode($api->AnimeDetail($id))->data->mal_id])->first();
            $fav = AnimeFavorite::where(['user_id' => auth()->user()->id, 'anime_id' => json_decode($api->AnimeDetail($id))->data->mal_id])->first();
        }

        // Forbidden Genre
        $genre = '';
        foreach (json_decode($api->AnimeDetail($id))->data->genres as $key => $value) {
            $genre .= $value->name . '#';
        }

        if (!array_intersect(explode('#', $genre), $api->ForbiddenGenre())) {
            if ($menu == 'watch') {
                return view('detail.watch')
                    ->with([
                        'title' => 'watch',
                        'list' => $list,
                        'fav' => $fav,
                        'detail' => json_decode($api->AnimeDetail($id))->data,
                        'videos' => json_decode($api->AnimeVideos($id, (request('page')) ?: 1))->data,
                        'pagination' => $api->Pagination(request('page'), $api->AnimeVideos($id, 1))[0]
                    ]);
            } else if ($menu == 'character') {
                return view('detail.character')
                    ->with([
                        'title' => 'character',
                        'list' => $list,
                        'fav' => $fav,
                        'detail' => json_decode($api->AnimeDetail($id))->data,
                        'characters' => json_decode($api->AnimeCharacter($id))->data,
                    ]);
            } else if ($menu == 'staff') {
                return view('detail.staff')
                    ->with([
                        'title' => 'staff',
                        'list' => $list,
                        'fav' => $fav,
                        'detail' => json_decode($api->AnimeDetail($id))->data,
                        'staff' => json_decode($api->AnimeStaff($id))->data,
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
