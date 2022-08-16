@if (count($detail->external) && count($detail->streaming))
<div class="bg-white p-4 rounded">
    <div class="fs-small mb-3 text-gray fw-bold">External & Streaming Links</div>
    @foreach ($detail->external as $item)
        @if ($item->name == 'Official Site')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="Official Site"><img src="{{ url('/asset/img/web.png') }}" width="20px"> Official Site</a>
            </div>
        @endif
    @endforeach
    @foreach ($detail->streaming as $item)
        @if ($item->name == 'Crunchyroll')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="Crunchyroll"><img src="{{ url('/asset/img/crunch.png') }}" width="20px"> Crunchyroll</a>
            </div>
        @endif
        @if ($item->name == 'Funimation')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="Funimation"><img class="rounded" src="{{ url('/asset/img/funimation.jpg') }}" width="20px"> Funimation</a>
            </div>
        @endif
        @if ($item->name == 'Netflix')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="Netflix"><img class="rounded" src="{{ url('/asset/img/netflix.png') }}" width="20px"> Netflix</a>
            </div>
        @endif
        @if ($item->name == 'Disney+')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="Disney+"><img class="rounded" src="{{ url('/asset/img/disney.jpeg') }}" width="20px"> Disney+</a>
            </div>
        @endif
        @if ($item->name == 'Aniplus TV')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="Aniplus TV"><img class="rounded" src="{{ url('/asset/img/aniplus.jpg') }}" width="20px"> Aniplus TV</a>
            </div>
        @endif
        @if ($item->name == 'Bilibili Global')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="Bilibili Global"><img class="rounded" src="{{ url('/asset/img/bilibili.jpeg') }}" width="20px"> Bilibili Global</a>
            </div>
        @endif
        @if ($item->name == 'CatchPlay')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="CatchPlay"><img class="rounded" src="{{ url('/asset/img/catch.png') }}" width="20px"> CatchPlay</a>
            </div>
        @endif
        @if ($item->name == 'Muse Asia')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="Muse Asia"><img class="rounded" src="{{ url('/asset/img/muse.png') }}" width="20px"> Muse Asia</a>
            </div>
        @endif
        @if ($item->name == 'iQIYI')
            <div class="fs-small mb-3">
                <a href="{{ $item->url }}" title="iQIYI"><img class="rounded" src="{{ url('/asset/img/iqiyi.png') }}" width="20px"> iQIYI</a>
            </div>
        @endif
    @endforeach
</div>
@endif