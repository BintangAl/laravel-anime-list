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

    <div class="bg-white p-4 rounded mb-3">
        <div class="row overpass">
            <div class="fs-5 mb-2 text-gray fw-bold">Staff</div>
            @foreach ($staff as $person)
            <div class="col-lg-4 col-sm-12 mb-3">
                <div class="bg-light border border-1 d-flex">
                    <img src="{{ $person->person->images->jpg->image_url }}" width="50px" alt="">
                    <div class="d-block mx-2 my-2">
                        <div class="text-gray fw-bold fs-small mb-3">{{ $person->person->name }}</div>
                        <div class="text-gray fs-xsmall">{{ $person->positions[0] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@include('partials.footer')
@endsection

@section('js') <script src="/js/detail.js"></script> @endsection
