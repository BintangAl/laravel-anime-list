<div class="row mb-3">
    <div class="col-lg-2 col-md-4 col-4">
        <div class="box shadow mb-3" style="width: 100%; margin-top:-80px">
            <img src="{{ $detail->images->webp->large_image_url }}" class="img-fluid" alt="">
        </div>
    </div>

    <div class="col-lg-9 col-md-8 col-12">
        <div class="text-gray fs-4 fw-bold">{{ $detail->title }}</div>
        <div class="text-gray fs-small" id="synopsis">{{ $detail->synopsis }}</div>
        <div class="text-center mb-3 fs-xsmall text-gray fw-bold pointer d-none" id="read-more">Read More <i class="fa-solid fa-chevron-down d-block"></i></div>
        <div class="text-center mb-3 fs-xsmall text-gray fw-bold pointer d-none" id="read-less"><i class="fa-solid fa-chevron-up d-block"></i> Read Less</div>
        <div class="d-flex">
            <div class="dropdown">
                <button class="btn btn-primary btn-sm px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="{{ $detail->mal_id }}">
                    @if ($list)
                    {{ $list->status }} <i class="fa-solid fa-caret-down ms-2"></i>
                    @else
                    <i class="fa-solid fa-circle-plus"></i> Add to List
                    @endif
                </button>
                <ul class="dropdown-menu fs-small">
                    <li>
                        <button class="dropdown-item" name="status" value="Completed#{{ $detail->mal_id }}#{{ $detail->title }}#{{ $detail->images->webp->large_image_url }}" onclick="addList(this.value)">
                        <i class="fa-solid fa-circle-check text-primary text-glow-blue me-1 fs-xsmall"></i> Set as Completed</button>
                    </li>
                    <li>
                        <button class="dropdown-item" name="status" value="Watching#{{ $detail->mal_id }}#{{ $detail->title }}#{{ $detail->images->webp->large_image_url }}" onclick="addList(this.value)">
                        <i class="fa-solid fa-play text-success text-glow-green me-1 fs-xsmall"></i> Set as Watching</button>
                    </li>
                    <li>
                        <button class="dropdown-item" name="status" value="Plan to Watch#{{ $detail->mal_id }}#{{ $detail->title }}#{{ $detail->images->webp->large_image_url }}" onclick="addList(this.value)">
                        <i class="fa-solid fa-list-check text-warning text-glow-yellow me-1 fs-xsmall"></i> Set as Plan to Watch</button>
                    </li>
                    <li>
                        <button class="dropdown-item" name="status" value="Rewatching#{{ $detail->mal_id }}#{{ $detail->title }}#{{ $detail->images->webp->large_image_url }}" onclick="addList(this.value)">
                        <i class="fa-solid fa-repeat text-success text-glow-green me-1 fs-xsmall"></i> Set as Rewatching</button>
                    </li>
                    <li>
                        <button class="dropdown-item" name="status" value="Paused#{{ $detail->mal_id }}#{{ $detail->title }}#{{ $detail->images->webp->large_image_url }}" onclick="addList(this.value)">
                        <i class="fa-solid fa-pause text-danger text-glow-red me-1 fs-xsmall"></i> Set as Paused</button>
                    </li>
                    @if ($list)
                    <li>
                        <button class="dropdown-item" name="status" value="Dropped#{{ $detail->mal_id }}#{{ $detail->title }}#{{ $detail->images->webp->large_image_url }}" onclick="addList(this.value)">
                        <i class="fa-solid fa-x text-danger text-glow-red me-1 fs-xsmall"></i> Set as Dropped</button>
                    </li>
                    @endif
                </ul>
            </div>
            <button class="btn bg-pink btn-sm fs-small fw-bold outline-none @if($fav) text-pink-light @else text-white @endif ms-2" id="add-fav" 
                value="@foreach($detail->genres as $genre) {{ $genre->name }},@endforeach#{{ $detail->mal_id }}#{{ $detail->title }}#{{ $detail->images->webp->large_image_url }}" 
                onclick="addFavorite(this.value)"><i class="fa-solid fa-heart"></i>
            </button>
        </div>

    </div>
</div>
<div class="d-flex justify-content-center overflow-auto" id="overview">
    <a href="{{ url('anime/'.$detail->mal_id.'/'.str_replace(' ', '_', $detail->title)) }}" class="overview fs-small {{ ($title == 'detail') ? 'text-primary' : 'text-gray' }} text-hover-blue pointer mx-3 fw-bold" onclick="load()">Overview</a>
    <a href="{{ url('anime/'.$detail->mal_id.'/'.str_replace(' ', '_', $detail->title).'/watch') }}" class="watch fs-small {{ ($title == 'watch') ? 'text-primary' : 'text-gray' }} text-hover-blue pointer mx-3 fw-bold" onclick="load()">Watch</a>
    <a href="{{ url('anime/'.$detail->mal_id.'/'.str_replace(' ', '_', $detail->title).'/character') }}" class="character fs-small {{ ($title == 'character') ? 'text-primary' : 'text-gray' }} text-hover-blue pointer mx-3 fw-bold" onclick="load()">Character</a>
    <a href="{{ url('anime/'.$detail->mal_id.'/'.str_replace(' ', '_', $detail->title).'/staff') }}" class="staff fs-small {{ ($title == 'staff') ? 'text-primary' : 'text-gray' }} text-hover-blue pointer mx-3 fw-bold" onclick="load()">Staff</a>
</div>