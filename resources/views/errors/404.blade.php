@extends('layouts.index')

@section('css')
<style>
    body {
        background-color: #D5E1C5 !important;
        user-select:none !important;
        overflow-y: hidden;
    }
</style>
@endsection

@section('container')

<div class="row align-items-center text-center">
    <div class="col-md-6 col-sm-12 overpass">
        <div class="fw-bold text-shadow" style="font-size: 150px; text-shadow: 2px 4px 2px #000000;color:#413330">404</div>
        <div class="fs-5 text-gray">Sorry, We cannot find</div>
        <div class="fs-5 text-gray">the requested page.</div>
        <div class="fs-1 fw-bold mb-4">You are lost!</div>
        <a href="{{ url('/') }}" class="btn rounded-pill text-white px-5 fs-4" style="background-color: #729C3D"><i class="fa-solid fa-house"></i> Go to Home</a>
    </div>
    <div class="col-md-6 col-sm-12">
        <img src="/asset/img/zoro.png" alt="404">

    </div>
</div>

@endsection