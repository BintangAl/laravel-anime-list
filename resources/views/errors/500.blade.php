@extends('layouts.index')

@section('css')
<style>
    body {
        background-color: #E84444 !important;
        user-select:none !important;
        overflow: hidden !important;
    }
</style>
@endsection

@section('container')

<div class="row text-center">
    <div class="col-md-6 col-sm-12 col-12 overpass mt-5">
        <div class="fw-bold text-white" style="font-size: 150px;">500</div>
        <div class="fs-1 fw-bold mb-4 text-white">Internet Server Error</div>
        <div class="d-flex justify-content-center">
            <div onclick="window.location='{{ url('/') }}'" class="btn btn-sm me-3 rounded-pill px-4 fs-5 btn-outline-light"><i class="fa-solid fa-house"></i> Go to Home</div>
            <div onclick="window.location.reload()" class="btn btn-sm rounded-pill px-4 fs-5 btn-outline-light"><i class="fa-solid fa-arrow-rotate-right"></i> Refresh</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-12">
        <img src="/asset/img/monica.webp" alt="500" width="700px">

    </div>
</div>

@endsection