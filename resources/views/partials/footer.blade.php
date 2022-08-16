<div class="overpass bg-main mt-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-5 d-flex justify-content-center justify-content-md-start">
                <a href="{{ url('/') }}"><img src="{{ url('/asset/img/banner.png') }}" alt="MUNN Anime List" width="150px"></a>
            </div>
            <div class="col-lg-3 col-md-12 text-lg-end">
                <a href="{{ url('top-anime') }}" class="fs-small text-gray-v2 fw-bold d-block text-hover-white mb-3">Top Anime List</a>
                <a href="{{ url('this-season') }}" class="fs-small text-gray-v2 fw-bold d-block text-hover-white mb-3">Popular This Season List</a>
                <a href="{{ url('next-season') }}" class="fs-small text-gray-v2 fw-bold d-block text-hover-white mb-5">Popular Next Season List</a>
            </div>
            <div class="col-lg-3 col-md-12 text-lg-end">
                <a target="_blank" href="https://twitter.com/BintangAl_" class="fs-small text-gray-v2 fw-bold d-block text-hover-white mb-3"><i class="fa-brands fa-twitter"></i> Twitter</a>
                <a target="_blank" href="https://www.instagram.com/bintangalsyahadat_/" class="fs-small text-gray-v2 fw-bold d-block text-hover-white mb-3"><i class="fa-brands fa-instagram"></i> Instagram</a>
                <a target="_blank" href="https://github.com/BintangAl" class="fs-small text-gray-v2 fw-bold d-block text-hover-white mb-5"><i class="fa-brands fa-github"></i> GitHub</a>
            </div>
            <div class="col-lg-3 col-md-12 text-lg-end">
                <a target="_blank" href="#" class="fs-small text-gray-v2 fw-bold d-block text-hover-white mb-3">Donate</a>
                <a target="_blank" href="https://chat.munn.my.id" class="fs-small text-gray-v2 fw-bold d-block text-hover-white mb-5">Munn ChatApp</a>
            </div>
        </div>
    </div>
</div>
<footer class="overpass fs-xsmall text-center bg-dark text-gray-v2 fw-bold pt-1">
    {{ date("Y") }} - <a href="{{ url('/') }}" class="text-gray-v2 fw-bold">Munn Anime List</a>
</footer>