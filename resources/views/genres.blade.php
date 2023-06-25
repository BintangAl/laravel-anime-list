@extends('layouts.index')

@section('container')

@include('partials.navbar')

<div class="container mt-5">
    <div class="row overpass mb-3">
        <div class="col-9">
            <label for="search" class="fw-bold text-gray">Search</label>
            <div class="input-group mb-3">
                <span class="input-group-text text-gray bg-white border border-end-0 fs-small" id="search"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border border-start-0 ps-0 shadow-none fs-small text-gray fw-bold" aria-describedby="search">
            </div>
        </div>
        <div class="col-3">
            <label for="genres" class="fw-bold text-gray">Genres</label>
            <select class="form-select shadow-none border fs-small fw-bold text-gray" id="filterByGenre" aria-label="Default select example" onchange="window.location=this.value, load()">
                <option value="{{ url('anime') }}">All</option>
                @foreach ($genres as $genre)
                    @if (!in_array($genre->name, $forbidden_genre))
                        @if (strtolower($genre->name) == $this_genre)
                        <option value="{{ url('genre/'. $genre->mal_id .'/'.strtolower($genre->name)) }}" data-id="{{ $genre->mal_id }}" class="fw-bold" selected>{{ $genre->name }}</option>                   
                        @else
                        <option value="{{ url('genre/'. $genre->mal_id .'/'.strtolower($genre->name)) }}" data-id="{{ $genre->mal_id }}" class="fw-bold">{{ $genre->name }}</option>                   
                        @endif
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="overpass d-none" id="search-view">
        <div class="fs-5 mb-2 text-gray fw-bold text-uppercase" id="keyword"></div>
        <div class="text-center fs-small fw-bold d-none" id="load-search">Loading...<img src="{{ url('/asset/img/load.gif') }}" width="40px"></div>        
        <div class="row search-list mb-4 d-none"></div>
    </div>
    
    <div class="list-view">
        <div class="row overpass mb-5">
            <div class="fs-5 mb-2">
                <a href="{{ url('top-anime') }}" class="text-gray fw-bold text-uppercase">GENRE : {{ $this_genre }}</a>
            </div>
            @foreach ($filter_genre as $item)
            <div class="col-lg-2 col-md-3 col-4 mb-3">
                <a href="{{ url('anime/'.$item->mal_id.'/'.str_replace(' ', '_', $item->title)) }}" class="box-anime placeholder-glow" style="overflow: hidden" onclick="load()">
                    <img src="{{ json_decode(json_encode($item->images->webp->large_image_url)) }}" class="img-fluid mb-2 placeholder w-100 h-200">
                    <div class="text-gray fw-bold fs-small text-truncate">{{ $item->title }}</div>
                </a>
            </div>
            @endforeach
        </div>

        @if ($pagination['all_page'] != 1)
            @include('partials.pagination')
        @endif
    </div>
</div>

@include('partials.footer')
@endsection