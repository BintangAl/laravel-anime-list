<x-guest-layout>
    <div class="container">
        <form method="POST" action="{{ route('login') }}" class="p-3 overpass" style="width: 350px">
            @csrf
            <div class="fs-3 text-center fw-bold text-white mb-3">Login</div>
    
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />
            <div class="mb-3">
                <label for="email" class="form-label text-white">Email address</label>
                <input type="email" class="form-control border-0 text-white shadow-none" id="email" name="email" style="background-color: #37373E">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-white">Password</label>
                <input type="password" class="form-control border-0 text-white shadow-none" id="password" name="password" style="background-color: #37373E">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label text-light fs-small" for="remember">Remember Me</label>
              </div>
    
            <button class="btn btn-light w-100 mb-3"><i class="fa-solid fa-right-to-bracket"></i> Log In</button>
            <div class="d-flex mb-3">
                <a href="{{ route('google.login') }}" class="btn btn-danger col-6 me-1"><i class="fab fa-google"></i>  Google</a>
                <a href="{{ route('facebook.login') }}" class="btn btn-primary col-6 ms-1"><i class="fab fa-facebook"></i>  Facebook</a>
            </div>
    
            <div class="text-center">
                <a href="{{ url('/register') }}" class="text-center text-gray fs-small pointer">Don't have an account? <span class="text-white">Register</span></a>
            </div>
        </form>
    </div>
</x-guest-layout>
