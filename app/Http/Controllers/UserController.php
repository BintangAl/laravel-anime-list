<?php

namespace App\Http\Controllers;

use App\Models\AnimeFavorite;
use App\Models\AnimeList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        return view('user.overview')
            ->with([
                'title' => "Profile"
            ]);
    }

    public function list()
    {
        return view('user.list')
            ->with([
                'title' => "Profile - List",
                'list' => AnimeList::where('user_id', auth()->user()->id)->get()
            ]);
    }

    public function searchList(Request $request)
    {
        $output = '';
        $list = '';
        if ($request->status == '') {
            $list = AnimeList::where([['user_id', '=', auth()->user()->id], ['title', 'Like', '%' . $request->search . '%']])->get();
        } else {
            $list = AnimeList::where([
                ['user_id', '=', auth()->user()->id],
                ['title', 'Like', '%' . $request->search . '%'],
                ['status', 'Like', '%' . $request->status . '%']
            ])->get();
        }

        foreach ($list as $item) {
            if ($item->status == "Completed") {
                $status = '<span class="fs-xsmall text-primary text-glow-blue"><i class="fa-solid fa-circle-check"></i></span> ';
            } elseif ($item->status == "Watching") {
                $status = '<span class="fs-xsmall text-success text-glow-green"><i class="fa-solid fa-play"></i></span> ';
            } elseif ($item->status == "Plan to Watch") {
                $status = '<span class="fs-xsmall text-warning text-glow-yellow"><i class="fa-solid fa-list-check"></i></span> ';
            } elseif ($item->status == "Rewatching") {
                $status = '<span class="fs-xsmall text-success text-glow-green"><i class="fa-solid fa-repeat"></i></span> ';
            } elseif ($item->status == "Paused") {
                $status = '<span class="fs-xsmall text-danger text-glow-red"><i class="fa-solid fa-pause"></i></span> ';
            }

            $output .= '
            <div class="col-lg-4 col-md-3 col-6 mb-3">
                <div class="card">
                    <a href="' . url('anime/' . $item->anime_id . '/' . str_replace(' ', '_', $item->title)) . '"><img src="' . $item->img . '" class="card-img-top" style="height: 100px; object-fit:cover"></a>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="detail text-truncate">
                                <a href="' . url('anime/' . $item->anime_id . '/' . str_replace(' ', '_', $item->title)) . '" class="card-title fw-bold mb-0">' . $item->title . '</a>
                                <div class="card-text fs-small user-select-none" id="' . $item->anime_id . '">
                                    ' . $status . '
                                    ' . $item->status . '
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu fs-small">
                                <li>
                                    <button class="dropdown-item" name="status" value="Completed#' . $item->anime_id . '#' . $item->title . '#' . $item->img . '" onclick="addList(this.value)">
                                    <i class="fa-solid fa-circle-check text-primary text-glow-blue me-1 fs-xsmall"></i> Set as Complete</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" name="status" value="Watching#' . $item->anime_id . '#' . $item->title . '#' . $item->img . '" onclick="addList(this.value)">
                                    <i class="fa-solid fa-play text-success text-glow-green me-1 fs-xsmall"></i> Set as Watching</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" name="status" value="Plan to Watch#' . $item->anime_id . '#' . $item->title . '#' . $item->img . '" onclick="addList(this.value)">
                                    <i class="fa-solid fa-list-check text-warning text-glow-yellow me-1 fs-xsmall"></i> Set as Plan to Watch</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" name="status" value="Rewatching#' . $item->anime_id . '#' . $item->title . '#' . $item->img . '" onclick="addList(this.value)">
                                    <i class="fa-solid fa-repeat text-success text-glow-green me-1 fs-xsmall"></i> Set as Rewatching</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" name="status" value="Paused#' . $item->anime_id . '#' . $item->title . '#' . $item->img . '" onclick="addList(this.value)">
                                    <i class="fa-solid fa-pause text-danger text-glow-red me-1 fs-xsmall"></i> Set as Paused</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" name="status" value="Dropped#' . $item->anime_id . '#' . $item->title . '#' . $item->img . '" onclick="addList(this.value)">
                                    <i class="fa-solid fa-x text-danger text-glow-red me-1 fs-xsmall"></i> Dropped</button>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }

        return response($output);
    }

    public function favorite()
    {
        $api = new ApiController();
        $genres = $api->genre();

        return view('user.favorite')
            ->with([
                'title' => "Profile - Favorite",
                'genre' => 'all',
                'genres' => $genres ? $genres->data : [],
                'forbidden_genre' => $api->ForbiddenGenre(),
                'favorite' => AnimeFavorite::where('user_id', auth()->user()->id)->get()
            ]);
    }

    public function searchFav(Request $request)
    {
        $output = '';
        $fav = '';
        if ($request->genre == '') {
            $fav = AnimeFavorite::where([['user_id', '=', auth()->user()->id], ['title', 'Like', '%' . $request->search . '%']])->get();
        } else {
            $fav = AnimeFavorite::where([
                ['user_id', '=', auth()->user()->id],
                ['title', 'Like', '%' . $request->search . '%'],
                ['genre', 'Like', '%' . $request->genre . '%']
            ])->get();
        }

        foreach ($fav as $item) {
            $output .= '
            <div class="col-lg-2 col-md-3 col-4 mb-3">
                <a href="' . url('anime/' . $item->anime_id . '/' . str_replace(' ', '_', $item->title)) . '" onclick="load()" class="box-anime bg-white">
                    <img src="' . $item->img . '" class="img-fluid mb-2" style="height: 170px; object-fit: cover">
                    <div class="text-gray fw-bold fs-small text-truncate">' . $item->title . '</div>
                </a>
            </div>
            ';
        }

        return response($output);
    }

    public function setting()
    {
        return view('user.setting.setting')
            ->with([
                'title' => "Profile - Setting"
            ]);
    }

    public function account()
    {
        return view('user.setting.account')
            ->with([
                'title' => "Profile - Setting"
            ]);
    }

    public function nameUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()
            ]);
        } else {
            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Name successfully changed'
            ]);
        }
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->password);
        $save = $user->save();

        if ($save) {
            return redirect('/profile/setting/account')->with('changeSuccess', 'Password successfully changed');
        } else {
            return redirect('/profile/setting/account')->with('changeFailed', 'Password failed changed');
        }
    }

    public function aboutUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'about' => 'max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()
            ]);
        } else {
            $user = User::find(auth()->user()->id);
            $user->about = $request->about;
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'About successfully changed'
            ]);
        }
    }

    public function avatarUpdate(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $validasi = $request->validate([
            'avatar' => 'required|image|file|max:3000|dimensions:ratio=0/0'
        ]);

        if ($request->file('avatar')) {
            $validasi['avatar'] = $request->file('avatar')->store('image');
            File::delete('storage/' . $user->avatar);

            DB::table('users')
                ->where('id', auth()->user()->id)
                ->update($validasi);

            return redirect('/profile/setting')->with('avatarSuccess', 'Avatar successfully changed');
        } else {
            return redirect('/profile/setting')->with('avatarFailed', 'Avatar failed changed');
        }
    }

    public function avatarDelete()
    {
        $user = User::find(auth()->user()->id);
        File::delete('storage/' . $user->avatar);
        $user->avatar = '';
        $delete = $user->save();

        if ($delete) {
            return redirect('/profile/setting')->with('deleteSuccess', 'Avatar successfully deleted');
        } else {
            return redirect('/profile/setting')->with('deleteFailed', 'Avatar failed deleted');
        }
    }

    public function bannerUpdate(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $validasi = $request->validate([
            'banner' => 'required|image|file|max:6000'
        ]);

        if ($request->file('banner')) {
            $validasi['banner'] = $request->file('banner')->store('image');
            File::delete('storage/' . $user->banner);

            DB::table('users')
                ->where('id', auth()->user()->id)
                ->update($validasi);

            return redirect('/profile/setting')->with('bannerSuccess', 'banner successfully changed');
        } else {
            return redirect('/profile/setting')->with('bannerFailed', 'banner failed changed');
        }
    }

    public function bannerDelete()
    {
        $user = User::find(auth()->user()->id);
        File::delete('storage/' . $user->banner);
        $user->banner = '';
        $delete = $user->save();

        if ($delete) {
            return redirect('/profile/setting')->with('deleteSuccess', 'Banner successfully deleted');
        } else {
            return redirect('/profile/setting')->with('deleteFailed', 'Banner failed deleted');
        }
    }
}
