<x-guest-layout>
    <div class="container">
        <form method="POST" action="{{ route('register') }}" class="p-3 overpass" style="width: 350px">
            @csrf
            <div class="fs-3 text-center fw-bold text-white mb-3">Register</div>
    
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />
            <div class="mb-3">
                <label for="name" class="form-label text-white">Username</label>
                <input type="text" class="form-control border-0 text-white shadow-none" id="name" name="name" style="background-color: #37373E">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label text-white">Email address</label>
                <input type="email" class="form-control border-0 text-white shadow-none" id="email" name="email" style="background-color: #37373E">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-white">Password</label>
                <input type="password" class="form-control border-0 text-white shadow-none" id="password" name="password" style="background-color: #37373E">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label text-white">Password Confirmation</label>
                <input type="password" class="form-control border-0 text-white shadow-none" id="password_confirmation" name="password_confirmation" style="background-color: #37373E">
            </div>
    
            <button class="btn btn-light w-100 mb-3"><i class="fa-solid fa-right-to-bracket"></i> Register</button>
            <div class="d-flex mb-3">
                <a href="{{ route('google.login') }}" class="btn btn-danger col-6 me-1"><i class="fab fa-google"></i>  Google</a>
                <a href="{{ route('facebook.login') }}" class="btn btn-primary col-6 ms-1"><i class="fab fa-facebook"></i>  Facebook</a>
            </div>
    
            <div class="text-center">
                <a href="{{ url('/login') }}" class="text-center text-gray fs-small pointer">Already registered? <span class="text-white">Login</span></a>
            </div>
        </form>
    </div>
</x-guest-layout>
