@extends('layouts.index')

@section('container')

@include('partials.navbar')
<div class="bg-main" id="bg-banner" style="background-image: url(@if(auth()->user()->banner)'/storage/{{ auth()->user()->banner }}'  @endif);">
    <input type="hidden" value="{{ auth()->user()->banner }}" id="banner-url">
    <div class="container">
        <div class="row align-items-end" style="height: 40vh;">
            <div class="col-lg-2 col-md-3 col-6" id="banner-view">
                @if (auth()->user()->avatar)
                    <img src="{{ url('storage/'.auth()->user()->avatar) }}" class="img-fluid rounded-top" width="200px">
                @else
                    <img src="{{ url('/asset/img/default.png') }}" class="img-fluid" width="200px">
                @endif
            </div>
            <div class="col-lg-6 col-6">
                <div class="text-white overpass fw-bold fs-3 mb-2 text-lowercase" id="username">
                    {{ auth()->user()->name }}
                    <div class="fs-small fw-normal text-capitalize text-truncate" id="about-text">{{ (auth()->user()->about) ? '"'. auth()->user()->about .'"' : '' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-white p-2 mb-3 mb-lg-5 scrollx" id="overview-profile">
    <div class="d-flex justify-content-start justify-content-md-center overpass">
        {{-- <a href="{{ url('/profile') }}" class="mx-3 col-lg-1 col-md-2 col-4 fw-bold overview {{ ($title == "Profile") ? "text-primary" : "text-gray" }} text-hover-blue fs-small pointer"><i class="fa-solid fa-street-view"></i> Overview</a> --}}
        <a href="{{ url('/profile/list') }}" class="mx-3 col-lg-1 col-md-2 col-4 fw-bold list {{ ($title == "Profile - List") ? "text-primary" : "text-gray" }} text-hover-blue fs-small pointer"><i class="fa-solid fa-list-check"></i> Anime List</a>
        <a href="{{ url('/profile/favorite') }}" class="mx-3 col-lg-1 col-md-2 col-4 fw-bold favorit {{ ($title == "Profile - Favorite") ? "text-primary" : "text-gray" }} text-hover-blue fs-small pointer"><i class="fa-solid fa-heart"></i> Favorites</a>
        <a href="{{ url('/profile/setting') }}" class="mx-3 col-lg-1 col-md-2 col-4 fw-bold setting {{ ($title == "Profile - Setting") ? "text-primary" : "text-gray" }} text-hover-blue fs-small pointer"><i class="fa-solid fa-gear"></i> Setting</a>
    </div>
</div>

@yield('container-profile')

@include('partials.footer')

@endsection

@section('js')<script src="/js/user.js"></script> @endsection