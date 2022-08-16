@extends('layouts.profile')

@section('container-profile')

<div class="container overpass">
    <div class="mb-5">
        {{-- <div class="text-center fw-bold text-gray user-select-none align-items-center py-5" style="height: 50vh"><i class="fa-solid fa-folder-open"></i> No Anime List Result</div> --}}
    
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-gray fw-bold d-block d-lg-none">Anime List</div>
                    <button class="btn bg-white btn-sm fs-6 text-gray border-0 d-block d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#setting" aria-expanded="false" aria-controls="setting">
                        <span class="fs-small fw-bold me-1">
                            @if($title == 'Profile - List') All @endif
                            @if($title == 'completed') Completed @endif
                            @if($title == 'watching') Watching @endif
                            @if($title == 'plan-to-watch') Plan to Watch @endif
                            @if($title == 'rewatching') Rewatching @endif
                            @if($title == 'paused') Paused @endif
                        </span>
                        <i class="fa-solid fa-caret-down"></i>
                    </button>
                </div>
                <div class="collapse d-lg-block" id="setting">
                    <div class="mb-3">
                        <div class="text-gray fw-bold d-none d-lg-block">Anime List</div>
                        <ul class="p-0">
                            <li class="@if($title == 'Profile - List') bg-gray @else bg-hover-white50 @endif rounded py-1 pointer" onclick="window.location='{{ url('/profile/list') }}'">
                                <div class="ps-3 fs-small @if($title == 'Profile - List') fw-bold @else text-gray text-hover-black @endif">All</div>
                            </li>
                            <li class="@if($title == 'completed') bg-gray @else bg-hover-white50 @endif rounded py-1 pointer" onclick="window.location='{{ url('/profile/list/completed') }}'">
                                <div class="ps-3 fs-small @if($title == 'completed') fw-bold @else text-gray text-hover-black @endif">Completed</div>
                            </li>
                            <li class="@if($title == 'watching') bg-gray @else bg-hover-white50 @endif rounded py-1 pointer" onclick="window.location='{{ url('/profile/list/watching') }}'">
                                <div class="ps-3 fs-small @if($title == 'watching') fw-bold @else text-gray text-hover-black @endif">Watching</div>
                            </li>
                            <li class="@if($title == 'plan') bg-gray @else bg-hover-white50 @endif rounded py-1 pointer" onclick="window.location='{{ url('/profile/list/plan-to-watch') }}'">
                                <div class="ps-3 fs-small @if($title == 'plan') fw-bold @else text-gray text-hover-black @endif">Plan to Watch</div>
                            </li>
                            <li class="@if($title == 'rewatching') bg-gray @else bg-hover-white50 @endif rounded py-1 pointer" onclick="window.location='{{ url('/profile/list/rewatching') }}'">
                                <div class="ps-3 fs-small @if($title == 'rewatching') fw-bold @else text-gray text-hover-black @endif">Rewatching</div>
                            </li>
                            <li class="@if($title == 'paused') bg-gray @else bg-hover-white50 @endif rounded py-1 pointer" onclick="window.location='{{ url('/profile/list/paused') }}'">
                                <div class="ps-3 fs-small @if($title == 'paused') fw-bold @else text-gray text-hover-black @endif">Paused</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-12">
                <div class="mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text text-gray bg-white border border-end-0 fs-small" id="search"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search-list" class="form-control border border-start-0 ps-0 shadow-none fs-small text-gray fw-bold" placeholder="Search" aria-describedby="search">
                    </div>
                </div>
                <div class="row" id="profile-list-view">
                    @foreach ($list as $item)
                    <div class="col-lg-4 col-md-3 col-6 mb-3">
                        <div class="card">
                            <a href="{{ url('anime/'.$item->anime_id.'/'.str_replace(' ', '_', $item->title)) }}"><img src="{{ $item->img }}" class="card-img-top" style="height: 100px; object-fit:cover"></a>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div class="detail text-truncate">
                                        <a href="{{ url('anime/'.$item->anime_id.'/'.str_replace(' ', '_', $item->title)) }}" class="card-title fw-bold mb-0">{{ $item->title }}</a>
                                        <div class="card-text text-gray fs-small user-select-none" id="{{ $item->anime_id }}">
                                            @if ($item->status == 'Completed')
                                            <span class="fs-xsmall text-primary text-glow-blue"><i class="fa-solid fa-circle-check"></i></span> 
                                            @endif
                                            @if ($item->status == 'Watching')
                                            <span class="fs-xsmall text-success text-glow-green"><i class="fa-solid fa-play"></i></span> 
                                            @endif
                                            @if ($item->status == 'Plan to Watch')
                                            <span class="fs-xsmall text-warning text-glow-yellow"><i class="fa-solid fa-list-check"></i></span> 
                                            @endif
                                            @if ($item->status == 'Rewatching')
                                            <span class="fs-xsmall text-success text-glow-green"><i class="fa-solid fa-repeat"></i></span> 
                                            @endif
                                            @if ($item->status == 'Paused')
                                            <span class="fs-xsmall text-danger text-glow-red"><i class="fa-solid fa-pause"></i></span> 
                                            @endif
                                            {{ $item->status }}
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu fs-small">
                                            <li>
                                                <button class="dropdown-item" name="status" value="Completed#{{ $item->anime_id }}#{{ $item->title }}#{{ $item->img }}" onclick="addList(this.value)">
                                                <i class="fa-solid fa-circle-check text-primary text-glow-blue me-1 fs-xsmall"></i> Set as Complete</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" name="status" value="Watching#{{ $item->anime_id }}#{{ $item->title }}#{{ $item->img }}" onclick="addList(this.value)">
                                                <i class="fa-solid fa-play text-success text-glow-green me-1 fs-xsmall"></i> Set as Watching</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" name="status" value="Plan to Watch#{{ $item->anime_id }}#{{ $item->title }}#{{ $item->img }}" onclick="addList(this.value)">
                                                <i class="fa-solid fa-list-check text-warning text-glow-yellow me-1 fs-xsmall"></i> Set as Plan to Watch</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" name="status" value="Rewatching#{{ $item->anime_id }}#{{ $item->title }}#{{ $item->img }}" onclick="addList(this.value)">
                                                <i class="fa-solid fa-repeat text-success text-glow-green me-1 fs-xsmall"></i> Set as Rewatching</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" name="status" value="Paused#{{ $item->anime_id }}#{{ $item->title }}#{{ $item->img }}" onclick="addList(this.value)">
                                                <i class="fa-solid fa-pause text-danger text-glow-red me-1 fs-xsmall"></i> Set as Paused</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" name="status" value="Dropped#{{ $item->anime_id }}#{{ $item->title }}#{{ $item->img }}" onclick="addList(this.value)">
                                                <i class="fa-solid fa-x text-danger text-glow-red me-1 fs-xsmall"></i> Dropped</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection