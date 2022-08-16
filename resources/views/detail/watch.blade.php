@extends('layouts.index')

@section('container')

@include('partials.navbar')

<div class="container">
    <div class="bg-white">
        <iframe class="w-100" src="https://www.youtube.com/embed/{{ $detail->trailer->youtube_id }}?enablejsapi=1&wmode=opaque&" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <div class="bg-white p-4 rounded-bottom mb-4">
        @include('partials.detail')
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-12 mb-3">
            <div class="bg-white p-4 rounded">
                <div class="text-gray fs-small mb-1"><span class="fw-bold">Format: </span>{{ $detail->type }}</div>
                <div class="text-gray fs-small mb-1">
                    <span class="fw-bold">Studios: </span>
                    @foreach ($detail->studios as $studio)
                    {{ $studio->name }}
                    @endforeach
                </div>
                <div class="text-gray fs-small mb-1"><span class="fw-bold">Episodes: </span>{{ $detail->episodes }}</div>
                <div class="text-gray fs-small mb-1"><span class="fw-bold">Duration: </span>{{ $detail->duration }}</div>
                <div class="text-gray fs-small mb-1"><span class="fw-bold">Status: </span>{{ $detail->status }}</div>
                <div class="text-gray fs-small mb-1"><span class="fw-bold">Aired: </span>{{ $detail->aired->string }}</div>
                <div class="text-gray fs-small mb-2"><span class="fw-bold">Rating: </span>{{ $detail->score }}</div>
                <div class="text-gray fs-small">
                    <span class="fw-bold">Genre: </span>
                    @foreach ($detail->genres as $genre)
                    <a href="{{ url('genre/'.$genre->mal_id.'/'.$genre->name) }}" class="text-primary">{{ $genre->name }}</a>,
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12 mb-3">
            <div class="bg-white p-4 rounded mb-3">
                <div class="row overpass mb-3">
                    <div class="fs-5 mb-2 text-gray fw-bold">Watch</div>
                    @foreach ($videos as $video)
                    <div class="col-lg-2 col-md-3 col-4 mb-3">
                        <a href="{{ $video->url }}" target="_blank" class="box-anime bg-white" style="overflow: hidden">
                            <img src="{{ ($video->images->jpg->image_url == null) ? '/asset/img/video.png' : $video->images->jpg->image_url }}" class="img-fluid mb-2">
                            <div class="text-gray fw-bold fs-small text-truncate">{{ $video->episode }} - {{ $video->title }}</div>
                        </a>
                    </div>
                    @endforeach
                </div>

                @if ($pagination['all_page'] != 1)
                    @include('partials.pagination')
                @endif
            </div>
        </div>
        
    </div>
</div>

@include('partials.footer')
@endsection

@section('js') <script src="/js/detail.js"></script> @endsection
