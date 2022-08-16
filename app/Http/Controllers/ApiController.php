<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function AllAnime($page)
    {
        // get all popular
        $top_anime = curl_init();
        curl_setopt_array($top_anime, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/top/anime?filter=bypopularity&page=' . $page,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_top_anime = curl_exec($top_anime);
        curl_close($top_anime);

        return $response_top_anime;
    }

    public function genre()
    {
        // get genre list
        $genres = curl_init();
        curl_setopt_array($genres, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/genres/anime',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_genre = curl_exec($genres);
        curl_close($genres);

        return $response_genre;
    }

    public function AnimeDetail($id)
    {
        $detail = curl_init();
        curl_setopt_array($detail, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime/' . $id . '/full',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_detail = curl_exec($detail);
        curl_close($detail);

        return $response_detail;
    }

    public function AnimeCharacter($id)
    {
        $characters = curl_init();
        curl_setopt_array($characters, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime/' . $id . '/characters',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_characters = curl_exec($characters);
        curl_close($characters);

        return $response_characters;
    }

    public function AnimeStaff($id)
    {
        $staff = curl_init();
        curl_setopt_array($staff, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime/' . $id . '/staff',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_staff = curl_exec($staff);
        curl_close($staff);

        return $response_staff;
    }

    public function AnimeStatistics($id)
    {
        $statistics = curl_init();
        curl_setopt_array($statistics, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime/' . $id . '/statistics',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_statistics = curl_exec($statistics);
        curl_close($statistics);

        return $response_statistics;
    }

    public function AnimeVideos($id, $page)
    {
        $videos = curl_init();
        curl_setopt_array($videos, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime/' . $id . '/videos/episodes?page=' . $page,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_videos = curl_exec($videos);
        curl_close($videos);

        return $response_videos;
    }

    public function Watch($id)
    {
        $watch = curl_init();
        curl_setopt_array($watch, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime/' . $id . '/videos',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_watch = curl_exec($watch);
        curl_close($watch);

        return $response_watch;
    }

    public function AnimeRelations($id)
    {
        $relations = curl_init();
        curl_setopt_array($relations, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime/' . $id . '/relations',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_relations = curl_exec($relations);
        curl_close($relations);

        return $response_relations;
    }

    public function recomended($id)
    {
        // recomended anime list
        $recomended = curl_init();
        curl_setopt_array($recomended, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime/' . $id . '/recommendations',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_recomended = curl_exec($recomended);
        curl_close($recomended);

        return $response_recomended;
    }

    public function TopAnime($page)
    {
        // get top anime list
        $top_anime = curl_init();
        curl_setopt_array($top_anime, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/watch/episodes/popular',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_top_anime = curl_exec($top_anime);
        curl_close($top_anime);

        return $response_top_anime;
    }

    public function ThisSeason($page)
    {
        // get populer this seasons anime list
        $this_season_anime = curl_init();
        curl_setopt_array($this_season_anime, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/seasons/now?page=' . $page,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_this_season_anime = curl_exec($this_season_anime);
        curl_close($this_season_anime);

        return $response_this_season_anime;
    }

    public function NextSeason($page)
    {
        // get populer next seasons anime list
        $next_season_anime = curl_init();
        curl_setopt_array($next_season_anime, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/seasons/upcoming?page=' . $page,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_next_season_anime = curl_exec($next_season_anime);
        curl_close($next_season_anime);

        return $response_next_season_anime;
    }

    public function Search($search, $genres)
    {
        // get search anime list
        $filter_search = curl_init();
        curl_setopt_array($filter_search, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime?q=' . $search . '&genres=' . $genres,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_filter_search = curl_exec($filter_search);
        curl_close($filter_search);

        return $response_filter_search;
    }

    public function FilterGenre($id)
    {
        // get filter genre anime list
        $filter_genre = curl_init();
        curl_setopt_array($filter_genre, array(
            CURLOPT_URL => 'https://api.jikan.moe/v4/anime?genres=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response_filter_genre = curl_exec($filter_genre);
        curl_close($filter_genre);

        return $response_filter_genre;
    }

    public function Pagination($page, $list)
    {
        $current_page = isset($page) ? $page : 1;
        $all_page = json_decode($list)->pagination->last_visible_page;
        $before = ($page <= $all_page) ? (int)$current_page - 1 : abort(404);
        $after = ($page <= $all_page) ? (int)$current_page + 1 : abort(404);

        return array([
            'all_page' => $all_page,
            'current_page' => $current_page,
            'before' => $before,
            'after' => $after
        ]);
    }

    public function ForbiddenGenre()
    {
        $forbidden_genre = [
            'Girls Love',
            'Hentai',
            'Erotica',
            'Harem',
            'Magical Sex Shift',
            12, 49, 35, 34, 65
        ];
        return $forbidden_genre;
    }
}
