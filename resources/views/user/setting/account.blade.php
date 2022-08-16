@extends('layouts.profile')

@section('container-profile')

<div class="container overpass">
    <div class="mb-5">
        {{-- <div class="text-center fw-bold text-gray user-select-none align-items-center py-5" style="height: 50vh"><i class="fa-solid fa-folder-open"></i> No Setting Result</div> --}}
        
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-gray fw-bold d-block d-lg-none">Setting</div>
                    <button class="btn bg-white fs-6 text-gray border-0 d-block d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#setting" aria-expanded="false" aria-controls="setting">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                </div>
                <div class="collapse d-lg-block" id="setting">
                    <div class="mb-3">
                        <div class="text-gray fw-bold d-none d-lg-block">Setting</div>
                        <ul class="p-0">
                            <li class="bg-hover-white50 rounded py-1 pointer" onclick="window.location='{{ '/profile/setting' }}'">
                                <div class="ps-3 fs-small text-gray text-hover-black">Profile</div>
                            </li>
                            <li class="bg-gray rounded py-1 pointer" onclick="window.location='{{ '/profile/setting/account' }}'">
                                <div class="ps-3 fs-small text-dark fw-bold">Account</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-12">
                <div class="bg-white rounded p-3">
                    <div class="mb-4">
                        <label for="name" class="form-label text-gray fw-bold">User Name</label>
                        <input type="text" class="form-control bg-light border-0 text-gray" id="name" value="{{ auth()->user()->name }}" onkeyup="nameChange(this.value)">
                        <div class="text-danger fs-small" id="name-invalid"></div>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label text-gray fw-bold mb-0">Email</label>
                        <input type="email" class="form-control bg-light border-0 text-gray shadow-none" id="email" value="{{ auth()->user()->email }}" readonly>
                    </div>
                    
                    <div class="mb-4">
                        <form action="{{ route('password-upadte') }}" method="post">
                            @csrf
                            <label for="password" class="form-label text-gray fw-bold mb-0">Change Password</label>
                            <div class="mb-3">
                                <input type="password" class="form-control bg-light text-gray @error('password') is-invalid border border-danger @else border-0 @enderror" name="password" placeholder="New Password" id="password" onkeyup="passwordChange()">
                                <div class="invalid-feedback fs-small">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <input type="password" class="form-control bg-light text-gray @error('password') is-invalid border border-danger @else border-0 @enderror" name="password_confirmation" placeholder="Confirm New Password">
                                <div class="invalid-feedback fs-small">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-primary btn-sm px-5 d-none" id="btn-save" onclick="laod()"><i class="fa-solid fa-key"></i> Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="feedback" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" id="feedback-text"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="/js/user.js"></script>
    @if (session()->has('changeSuccess'))
    <script>
        $( document ).ready(function() {
            $("#feedback").toast('show');
            $("#feedback-text").addClass("text-success");
            $("#feedback-text").html('<i class="fa-solid fa-circle-check"></i> Password successfully changed');
        });
    </script>
    @endif

    @if (session()->has('changeFailed'))
    <script>
        $( document ).ready(function() {
            $("#feedback").toast('show');
            $("#feedback-text").addClass("text-danger");
            $("#feedback-text").html('<i class="fa-solid fa-circle-exclamation"></i> Password failed changed');
        });
    </script>
    @endif
@endsection