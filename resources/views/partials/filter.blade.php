<div class="row overpass mb-3">
    <div class="col-9">
        <label for="search" class="fw-bold text-gray">Search</label>
        <div class="input-group mb-3">
            <span class="input-group-text text-gray bg-white border border-end-0 fs-small" id="search"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" name="search" class="form-control border border-start-0 ps-0 shadow-none fs-small text-gray fw-bold" aria-describedby="search">
        </div>
    </div>
    <div class="col-3">
        <label for="genres" class="fw-bold text-gray">Genres</label>
        <select class="form-select shadow-none border fs-small fw-bold text-gray" aria-label="Default select example" onchange="window.location=this.value, load()">
            <option value="{{ url('anime') }}">All</option>
            @foreach ($genres as $genre)
                @if (!in_array($genre->name, $forbidden_genre))
                <option value="{{ url('genre/'. $genre->mal_id .'/'.strtolower($genre->name)) }}" class="fw-bold">{{ $genre->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>