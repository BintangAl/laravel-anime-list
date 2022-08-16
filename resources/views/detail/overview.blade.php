@extends('layouts.index')

@section('container')

@include('partials.navbar')

<div class="container">
    <div class="bg-white">
        <iframe class="w-100" src="https://www.youtube.com/embed/{{ $detail->trailer->youtube_id }}?enablejsapi=1&wmode=opaque&loop=1&playlist={{ $detail->trailer->youtube_id }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <div class="bg-white p-4 rounded-bottom mb-4">
        @include('partials.detail')
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="bg-white p-4 rounded mb-3">
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
            
            <div class="d-none d-lg-block mt-3">
                @include('partials.external-stream')
            </div>
        </div>
        <div class="col-md-9 col-sm-12 mb-3">
            @if (count($detail->relations) > 1)
            <div class="bg-white p-4 rounded mb-3">
                <div class="fs-5 mb-2 text-gray fw-bold">Relations</div>
                <div id="relations">
                    <div class="d-flex overpass" style="overflow: auto">
                        @foreach ($detail->relations as $rel)
                            @if ($rel->relation != 'Adaptation')
                                @foreach ($rel->entry as $item)
                                <div class="me-4" style="width: 120px">
                                    <a href="{{ url('anime/'.$item->mal_id.'/'.str_replace(' ', '_', $item->name)) }}" class="box-anime placeholder-glow" style="overflow: hidden">
                                        <div class="relation-image" id="{{ $item->mal_id }}">
                                            <div class="mb-2 placeholder col-12" style="height: 150px"></div>
                                        </div>
                                        <div class="text-gray fw-bold fs-small text-truncate" style="width: 120px">{{ $item->name }}</div>
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <div class="bg-white p-4 rounded mb-3">
                <div class="row overpass">
                    <a onclick="load()" href="{{ route('datail-menu', [$detail->mal_id, str_replace(' ', '_', $detail->title), 'character']) }}" class="fs-5 mb-2 text-gray fw-bold">Character</a>
                    @foreach ($characters as $character)
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="bg-light d-flex justify-content-between">
                            <div class="d-flex">
                                <img src="{{ $character->character->images->webp->image_url }}" width="50px" alt="" style="object-fit: cover">
                                <div class="d-block mx-2 my-2">
                                    <div class="text-gray fw-bold fs-small">{{ $character->character->name }}</div>
                                    <div class="text-gray fs-xsmall">{{ $character->role }}</div>
                                </div>
                            </div>
                            <div class="d-flex text-end">
                                @foreach ($character->voice_actors as $key => $value)
                                @if ($key == 0)
                                <div class="d-block mx-2 my-2">
                                    <div class="text-gray fw-bold fs-small">{{ $value->person->name }}</div>
                                    <div class="text-gray fs-xsmall">Voice Actor</div>
                                </div>
                                <img src="{{ $value->person->images->jpg->image_url }}" width="50px" alt="">
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-4 rounded mb-3">
                <div class="row overpass">
                    <a onclick="load()" href="{{ route('datail-menu', [$detail->mal_id, str_replace(' ', '_', $detail->title), 'staff']) }}" class="fs-5 mb-2 text-gray fw-bold">Staff</a>
                    @foreach ($staff as $person)
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="bg-light d-flex">
                            <img src="{{ $person->person->images->jpg->image_url }}" width="50px" alt="" style="object-fit: cover">
                            <div class="d-block mx-2 my-2">
                                <div class="text-gray fw-bold fs-small mb-3">{{ $person->person->name }}</div>
                                <div class="text-gray fs-xsmall">{{ $person->positions[0] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-4 rounded mb-3">
                <div class="fs-5 mb-2 text-gray fw-bold">Status Distribution</div>
                @if ($statistics)
                <div class="d-flex overpass scrollx">
                    <div class="complete">
                        <div class="btn bg-green-light text-white fs-small fw-bold me-3">Completed</div>
                        <div class="fs-small text-gray">{{ $statistics->completed }}</div>
                        <div class="text-green-light fs-xsmall">Users</div>
                    </div>
                    <div class="current">
                        <div class="btn bg-blue-light text-white fs-small fw-bold me-3">Current</div>
                        <div class="fs-small text-gray">{{ $statistics->watching }}</div>
                        <div class="text-blue-light fs-xsmall">Users</div>
                    </div>
                    <div class="planning">
                        <div class="btn bg-purple text-white fs-small fw-bold me-3">Planning</div>
                        <div class="fs-small text-gray">{{ $statistics->plan_to_watch }}</div>
                        <div class="text-purple fs-xsmall">Users</div>
                    </div>
                    <div class="paused">
                        <div class="btn bg-pink-light text-white fs-small fw-bold me-3">Paused</div>
                        <div class="fs-small text-gray">{{ $statistics->on_hold }}</div>
                        <div class="text-pink-light fs-xsmall">Users</div>
                    </div>
                </div>
                @endif
            </div>

            <div class="bg-white p-4 rounded mb-3">
                <div class="row overpass">
                    <a onclick="load()" href="{{ route('datail-menu', [$detail->mal_id, str_replace(' ', '_', $detail->title), 'watch']) }}" class="fs-5 mb-2 text-gray fw-bold">Watch</a>
                    @foreach ($videos as $video)
                    <div class="col-lg-2 col-md-3 col-4 mb-3">
                        <a href="{{ $video->url }}" target="_blank" class="box-anime bg-white" style="overflow: hidden">
                            <img src="{{ ($video->images->jpg->image_url == null) ? '/asset/img/video.png' : $video->images->jpg->image_url }}" class="img-fluid mb-2">
                            <div class="text-gray fw-bold fs-small text-truncate">{{ $video->episode }} - {{ $video->title }}</div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="d-block d-lg-none mb-3">
                @include('partials.external-stream')
            </div>

            <div class="bg-white p-4 rounded mb-3">
                <div class="row overpass">
                    <div class="fs-5 mb-2 text-gray fw-bold">Recommendations</div>
                    @foreach ($recomended as $recomend)
                    <div class="col-lg-2 col-md-3 col-4 mb-3">
                        <a href="{{ url('anime/'.$recomend->entry->mal_id.'/'.str_replace(' ', '_', $recomend->entry->title)) }}" onclick="load()" class="box-anime bg-white" style="overflow: hidden">
                            <img src="{{ json_decode(json_encode($recomend->entry->images->webp->large_image_url)) }}" class="img-fluid mb-2">
                            <div class="text-gray fw-bold fs-small text-truncate">{{ $recomend->entry->title }}</div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection

@section('js') <script src="/js/detail.js"></script> @endsection
