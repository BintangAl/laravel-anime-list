<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function GetAnime($url, $page = false, $limit = false)
    {
        // get all popular
        $qpage = '&page=' . $page;
        $qlimit = '&limit=' . $limit;

        $respone = Http::get($url . (!empty($page) ? $qpage : '') . (!empty($limit) ? $qlimit : ''));
        return $respone->successful() ? json_decode($respone->body()) : [];
    }

    public function TopAnime($page)
    {
        // get top anime list
        $respone = Http::get('https://api.jikan.moe/v4/watch/episodes/popular');
        return $respone->successful() ? json_decode($respone->body()) : [];
    }

    public function genre()
    {
        // get genre list
        $respone = Http::get('https://api.jikan.moe/v4/genres/anime');
        return $respone->successful() ? json_decode($respone->body()) : json_decode('{"data": []}');
    }

    public function AnimeDetail($id)
    {
        $respone = Http::get('https://api.jikan.moe/v4/anime/' . $id . '/full');
        return $respone->successful() ? json_decode($respone->body()) : json_decode('{"data": []}');
    }

    public function AnimeCharacter($id)
    {
        $respone = Http::get('https://api.jikan.moe/v4/anime/' . $id . '/characters');
        return $respone->successful() ? json_decode($respone->body()) : json_decode('{"data": []}');
    }

    public function AnimeStaff($id)
    {
        $respone = Http::get('https://api.jikan.moe/v4/anime/' . $id . '/staff');
        return $respone->successful() ? json_decode($respone->body()) : json_decode('{"data": []}');
    }

    public function AnimeStatistics($id)
    {
        $respone = Http::get('https://api.jikan.moe/v4/anime/' . $id . '/statistics');
        return $respone->successful() ? json_decode($respone->body()) : json_decode('{"data": []}');
    }

    public function Watch($id)
    {
        $respone = Http::get('https://api.jikan.moe/v4/anime/' . $id . '/videos');
        return $respone->successful() ? json_decode($respone->body()) : json_decode('{"data": []}');
    }

    public function AnimeVideos($id, $page)
    {
        $respone = Http::get('https://api.jikan.moe/v4/anime/' . $id . '/videos/episodes?page=' . $page);
        return $respone->successful() ? json_decode($respone->body()) : [];
    }

    public function AnimeRelations($id)
    {
        $respone = Http::get('https://api.jikan.moe/v4/anime/' . $id . '/relations');
        return $respone->successful() ? json_decode($respone->body()) : json_decode('{"data": []}');
    }

    public function Recomended($id)
    {
        // recomended anime list
        $respone = Http::get('https://api.jikan.moe/v4/anime/' . $id . '/recommendations');
        return $respone->successful() ? json_decode($respone->body()) : json_decode('{"data": []}');
    }

    public function Search($search, $genres)
    {
        // get search anime list
        $respone = Http::get('https://api.jikan.moe/v4/anime?q=' . $search . '&genres=' . $genres);
        return $respone->successful() ? json_decode($respone->body()) : [];
    }

    public function FilterGenre($id, $search = false, $page = 1)
    {
        // get filter genre anime list
        $qpage = '&page=' . $page;
        $qsearch = '&search=' . $search;
        $respone = Http::get('https://api.jikan.moe/v4/anime?genres=' . $id . (!empty($search) ? $qsearch : '') . (!empty($page) ? $qpage : ''));
        return $respone->successful() ? json_decode($respone->body()) : [];
    }

    public function Pagination($page, $list)
    {
        $current_page = isset($page) ? $page : 1;
        $all_page = $list->pagination->last_visible_page;
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
