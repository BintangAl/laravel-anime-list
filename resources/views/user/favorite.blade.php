@extends('layouts.profile')

@section('container-profile')

<div class="container overpass">
    <div class="mb-5">
        {{-- <div class="text-center fw-bold text-gray user-select-none align-items-center py-5" style="height: 50vh"><i class="fa-solid fa-folder-open"></i> No Favorite Result</div> --}}
    
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-gray fw-bold d-block d-lg-none">Anime Favorite</div>
                    <button class="btn bg-white btn-sm fs-6 text-gray border-0 d-block d-lg-none" id="genre" value="{{ $genre }}" type="button" data-bs-toggle="collapse" data-bs-target="#setting" aria-expanded="false" aria-controls="setting">
                        <span class="fs-small fw-bold me-1">
                            @if ($genre == 'all') All @endif
                        </span>
                        <i class="fa-solid fa-caret-down"></i>
                    </button>
                </div>
                <div class="collapse d-lg-block" id="setting">
                    <div class="mb-3">
                        <div class="text-gray fw-bold d-none d-lg-block">Anime Favorite</div>
                        <ul class="row p-0">
                            <li class="col-lg-12 col-md-3 col-4 @if($genre == 'all') bg-gray @else bg-hover-white50 @endif rounded py-1 pointer" onclick="window.location='{{ url('/profile/favorite') }}'">
                                <div class="ps-3 fs-small @if($genre == 'all') fw-bold @else text-gray text-hover-black @endif">All</div>
                            </li>

                            @foreach ($genres as $genre)
                                @if (!in_array($genre->name, $forbidden_genre))
                                <li class="col-lg-12 col-md-3 col-4 bg-hover-white50 rounded py-1 pointer" id="genre-list-{{ $genre->name }}" onclick="window.location='{{ url('/profile/favorite/'.str_replace(' ', '_' ,$genre->name)) }}'">
                                    <div class="ps-3 fs-small text-gray text-hover-black" id="genre-name-{{ $genre->name }}">{{ $genre->name }}</div>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-12">
                <div class="mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text text-gray bg-white border border-end-0 fs-small" id="search"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search-fav" class="form-control border border-start-0 ps-0 shadow-none fs-small text-gray fw-bold" placeholder="Search" aria-describedby="search">
                    </div>
                </div>
                <div class="row" id="profile-fav-view">
                    @foreach ($favorite as $fav)
                    <div class="col-lg-2 col-md-3 col-4 mb-3">
                        <a href="{{ url('anime/'.$fav->anime_id.'/'.str_replace(' ', '_', $fav->title)) }}" onclick="load()" class="box-anime bg-white">
                            <img src="{{ $fav->img }}" class="img-fluid mb-2" style="height: 170px; object-fit: cover">
                            <div class="text-gray fw-bold fs-small text-truncate">{{ $fav->title }}</div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection