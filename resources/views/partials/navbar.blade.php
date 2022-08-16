<nav class="navbar navbar-dark navbar-expand-lg bg-main sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ url('/asset/img/logo.png') }}" width="40px" alt="Munn Anime">
        </a>
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            @auth
            <li class="nav-item me-5">
                <a class="nav-link {{ ($title == 'home') ? 'text-blue-gray-light' : 'text-blue-gray'}} overpass fw-bold fs-small" href="{{ url('/') }}"><i class="fa-solid fa-house"></i> Home</a>
            </li>
            <li class="nav-item me-5">
                <a class="nav-link {{ ($title == 'ALL TIME POPULAR') ? 'text-blue-gray-light' : 'text-blue-gray'}} overpass fw-bold fs-small" href="{{ url('/anime') }}"><i class="fa-solid fa-play"></i> Anime Popular</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ ($title == 'profile') ? 'text-blue-gray-light' : 'text-blue-gray'}} overpass fw-bold fs-small" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user"></i> {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item overpass fw-bold fs-small" href="{{ url('/profile') }}"><i class="fa-solid fa-user"></i> Profile</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                      <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item btn overpass fw-bold fs-small" type="submit" onclick="load()"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                      </form>
                  </li>
                </ul>
              </li>
            @else
            <li class="nav-item me-3">
                <a class="nav-link active text-blue-gray overpass fw-bold fs-small" href="{{ url('/login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-primary btn-hover shadow-none overpass fw-bold fs-small text-white px-3" href="{{ url('/register') }}">Sign Up</a>
            </li>
            @endauth            
        </ul>
        </div>
    </div>
</nav>