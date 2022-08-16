@extends('layouts.index')

@section('container')

@include('partials.navbar')

<div class="container mt-3 mt-lg-5">
    @include('partials.filter')

    <div class="overpass d-none" id="search-view">
        <div class="fs-5 mb-2 text-gray fw-bold text-uppercase" id="keyword"></div>
        <div class="text-center fs-small fw-bold d-none" id="load-search">Loading...<img src="{{ url('/asset/img/load.gif') }}" width="40px"></div>        
        <div class="row search-list mb-4 d-none"></div>
    </div>

    <div class="list-view">
        <div class="row overpass mb-4">
            <div class="fs-5 mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ url('/anime/top') }}" class="text-gray fw-bold">TOP ANIME</a>
                <a href="{{ url('/anime/top') }}" class="text-gray fs-small text-hover-blue">view all <i class="fa-solid fa-circle-right"></i></a>
            </div>
            @foreach ($top_anime as $top)
            <div class="col-lg-2 col-md-3 col-4 mb-3">
                <a href="{{ url('anime/'.$top->entry->mal_id.'/'.str_replace(' ', '_', $top->entry->title)) }}" onclick="load()" aria-hidden="true" class="box-anime placeholder-glow" style="overflow: hidden">
                    @foreach ($top_image as $item)
                        @if (strtok($item, ',') == $top->entry->mal_id)
                            <img src="{{ substr($item, strpos($item, ",") + 1) }}" class="img-fluid mb-2 placeholder w-100 h-20"> 
                        @endif
                    @endforeach
                    <div class="text-gray fw-bold fs-small text-truncate">{{ $top->entry->title }}</div>
                </a>
            </div>
            @endforeach
        </div>
    
        <div class="row overpass mb-4">
            <div class="fs-5 mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ url('/anime/this-season') }}" class="text-gray fw-bold">POPULAR THIS SEASON</a>
                <a href="{{ url('/anime/this-season') }}" class="text-gray fs-small text-hover-blue">view all <i class="fa-solid fa-circle-right"></i></a>
            </div>
            @foreach ($this_season_anime as $this_season)
                @if ($this_season->popularity <= 855)
                <div class="col-lg-2 col-md-3 col-4 mb-3">
                    <a href="{{ url('anime/'.$this_season->mal_id.'/'.str_replace(' ', '_', $this_season->title)) }}" onclick="load()" class="box-anime bg-white" style="overflow: hidden">
                        <img src="{{ json_decode(json_encode($this_season->images->webp->large_image_url)) }}" class="img-fluid mb-2">
                        <div class="text-gray fw-bold fs-small text-truncate">{{ $this_season->title }}</div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    
        <div class="row overpass mb-4">
            <div class="fs-5 mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ url('/anime/next-season') }}" class="text-gray fw-bold">POPULAR NEXT SEASON</a>
                <a href="{{ url('/anime/next-season') }}" class="text-gray fs-small text-hover-blue">view all <i class="fa-solid fa-circle-right"></i></a>
            </div>
            @foreach ($next_season_anime as $next_season)
                @if ($next_season->popularity <= 1196)
                <div class="col-lg-2 col-md-3 col-4 mb-3">
                    <a href="{{ url('anime/'.$next_season->mal_id.'/'.str_replace(' ', '_', $next_season->title)) }}" onclick="load()" class="box-anime bg-white" style="overflow: hidden">
                        <img src="{{ json_decode(json_encode($next_season->images->webp->large_image_url)) }}" class="img-fluid mb-2">
                        <div class="text-gray fw-bold fs-small text-truncate">{{ $next_season->title }}</div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>

        <div class="row overpass mb-4">
            <div class="fs-5 mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ url('/anime') }}" class="text-gray fw-bold">ALL TIME POPULAR</a>
                <a href="{{ url('/anime') }}" class="text-gray fs-small text-hover-blue">view all <i class="fa-solid fa-circle-right"></i></a>
            </div>
            @foreach ($all_anime as $all)
            <div class="col-lg-2 col-md-3 col-4 mb-3">
                <a href="{{ url('anime/'.$all->mal_id.'/'.str_replace(' ', '_', $all->title)) }}" onclick="load()" class="box-anime bg-white" style="overflow: hidden">
                    <img src="{{ json_decode(json_encode($all->images->webp->large_image_url)) }}" class="img-fluid mb-2">
                    <div class="text-gray fw-bold fs-small text-truncate">{{ $all->title }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@include('partials.footer')
@endsection