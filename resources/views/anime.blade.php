@extends('layouts.index')

@section('container')
@include('partials.navbar')

<div class="container my-5">
    @include('partials.filter')

    <div class="overpass d-none" id="search-view">
        <div class="fs-5 mb-2 text-gray fw-bold text-uppercase" id="keyword"></div>
        <div class="text-center fs-small fw-bold d-none" id="load-search">Loading...<img src="{{ url('/asset/img/load.gif') }}" width="40px"></div>        
        <div class="row search-list mb-4 d-none"></div>
    </div>

    <div class="list-view">
        @if ($title != '')
        <div class="row overpass mb-3">
            <div class="fs-5 mb-2">
                <a href="{{ url('top-anime') }}" class="text-gray fw-bold">{{ $title }}</a>
            </div>
            @foreach ($data as $item)
            <div class="col-lg-2 col-md-3 col-4 mb-3">
                <a href="{{ url('anime/'.(($title == 'TOP ANIME') ? $item->entry->mal_id : $item->mal_id).'/'. str_replace(' ', '_', (($title == 'TOP ANIME') ? $item->entry->title : $item->title))) }}" onclick="load()" class="box-anime placeholder-glow" style="overflow: hidden">
                    @if ($title == 'TOP ANIME')
                    @foreach ($image as $img)
                        @if (strtok($img, ',') == $item->entry->mal_id)
                            <img src="{{ substr($img, strpos($img, ",") + 1) }}" class="img-fluid mb-2 placeholder w-100 h-20"> 
                        @endif
                    @endforeach
                    @endif
                    @if ($title != 'TOP ANIME')
                        <img src="{{ $item->images->webp->large_image_url }}" class="img-fluid mb-2 placeholder w-100 h-200">
                    @endif
                    <div class="text-gray fw-bold fs-small text-truncate">{{ ($title == 'TOP ANIME') ? $item->entry->title : $item->title }}</div>
                </a>
            </div>
            @endforeach
        @endif
        </div>
        
        @if ($pagination['all_page'] != 1)
            @include('partials.pagination')
        @endif
    </div>
</div>

@include('partials.footer')
@endsection