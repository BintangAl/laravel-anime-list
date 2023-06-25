<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\UserController;
use App\Models\AnimeFavorite;
use App\Models\AnimeList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

// Profile
Route::get('/profile', [UserController::class, 'list'])->middleware('auth');
Route::get('/profile/list', [UserController::class, 'list'])->middleware('auth');
Route::get('/profile/favorite', [UserController::class, 'favorite'])->middleware('auth');
Route::get('/profile/setting', [UserController::class, 'setting'])->middleware('auth');
Route::get('/profile/setting/account', [UserController::class, 'account'])->middleware('auth');

// Profile List
Route::get('/profile/list/{status}', function ($status) {
    if ($status == 'plan-to-watch') {
        $status = 'Plan To Watch';
    }
    return view('user.list')
        ->with([
            'title' => $status,
            'list' => AnimeList::where(['user_id' => auth()->user()->id, 'status' => $status])->get()
        ]);
});
Route::get('/search-list', [UserController::class, 'searchList'])->middleware('auth');

// Profile Favorite
Route::get('/profile/favorite/{genre}', function ($genre) {
    $api = new ApiController();
    $genres = $api->genre();

    return view('user.favorite')
        ->with([
            'title' => "Profile - Favorite",
            'genre' => $genre,
            'genres' => $genres ? $genres->data : [],
            'favorite' => AnimeFavorite::where([['user_id', '=', auth()->user()->id], ['genre', 'Like', '%' . $genre . '%']])->get()
        ]);
});
Route::get('/search-fav', [UserController::class, 'searchFav'])->middleware('auth');


// Profile Setting
Route::post('/profile/setting/account/name-update', [UserController::class, 'nameUpdate'])->middleware('auth');
Route::post('/profile/setting/account/password-update', [UserController::class, 'passwordUpdate'])->middleware('auth')->name('password-upadte');
Route::post('/profile/setting/about-update', [UserController::class, 'aboutUpdate'])->middleware('auth');

Route::post('/profile/setting/avatar-update', [UserController::class, 'avatarUpdate'])->middleware('auth')->name('avatar');
Route::post('/profile/setting/avatar-delete', [UserController::class, 'avatarDelete'])->middleware('auth')->name('delete-avatar');

Route::post('/profile/setting/banner-update', [UserController::class, 'bannerUpdate'])->middleware('auth')->name('banner');
Route::post('/profile/setting/banner-delete', [UserController::class, 'bannerDelete'])->middleware('auth')->name('delete-banner');

Route::get('/', [ListController::class, 'index']);
Route::get('/anime', [ListController::class, 'AnimeList']);
Route::get('/search', [ListController::class, 'search']);
Route::get('/genre/{id}/{genre}', [ListController::class, 'Genre']);

Route::get('/anime/{data}', [ListController::class, 'Anime']);

Route::get('/anime/{id}/{title}', [ListController::class, 'Detail']);
Route::get('/anime/{id}/{title}/{menu}', [ListController::class, 'DetailMenu'])->name('datail-menu');

Route::post('/rel-image', [ListController::class, 'RelationImage']);
Route::post('/anime/add-to-list', [ListController::class, 'AddList'])->middleware('auth')->name('add-to-list');
Route::post('/anime/add-to-favorite', [ListController::class, 'AddFavorite'])->middleware('auth')->name('add-to-favorite');
