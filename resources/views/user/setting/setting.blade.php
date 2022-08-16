@extends('layouts.profile')

@section('css') <link rel="stylesheet" href="/css/drop.css"> @endsection

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
                            <li class="bg-gray rounded py-1 pointer" onclick="window.location='{{ '/profile/setting' }}'">
                                <div class="ps-3 fs-small text-dark fw-bold">Profile</div>
                            </li>
                            <li class="bg-hover-white50 rounded py-1 pointer" onclick="window.location='{{ '/profile/setting/account' }}'">
                                <div class="ps-3 fs-small text-gray text-hover-black">Account</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-12">
                <div class="bg-white rounded p-3">
                    <div class="mb-4">
                        <label for="about" class="form-label text-gray fw-bold">About</label>
                        <input type="text" class="form-control bg-light border-0 text-gray" id="about" value="{{ auth()->user()->about }}" onkeyup="aboutChange(this.value)">
                        <div class="text-danger fs-small" id="about-invalid"></div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label for="avatar" class="form-label text-gray fw-bold mb-0">Avatar</label>
                            <form action="{{ route('delete-avatar') }}" method="post">
                                @csrf
                                <button class="btn btn-danger btn-sm fs-xsmall @if(!auth()->user()->avatar) d-none @endif" title="Delete Avatar" type="{{ (!auth()->user()->avatar) ? 'button' : 'submit' }}" onclick="load()"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>

                        <p class="form-label text-gray fs-small">Allowed Formats: JPEG, PNG. Max size: 3mb. Required dimensions 1:1</p>
                        
                        <form action="{{ route('avatar') }}" method="post" style="width: 230px" enctype="multipart/form-data">
                            @csrf
                            <div class="box-avatar mb-3">
                                <label for="avatar" class="drag-area-avatar pointer">
                                    <div class="icon">
                                      <i class="fas fa-images"></i>
                                    </div>
                            
                                    <span class="header-avatar">Drag & Drop</span>
                                    <span class="header-avatar">or <span class="button-avatar">browse</span></span>
                                    <span class="support">Supports: JPEG, JPG, PNG</span>
                                </label>
                                <input type="file" hidden id="avatar" name="avatar"/>
                            </div>
                            <div class="d-flex justify-content-center d-none" id="avatar-save">
                                <button class="btn btn-primary btn-sm px-5" id="btn-save" onclick="load()"><i class="fa-solid fa-floppy-disk"></i> Change Avatar</button>
                            </div>
                        </form>

                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label for="banner" class="form-label text-gray fw-bold mb-0">Banner</label>
                            <form action="{{ route('delete-banner') }}" method="post">
                                @csrf
                                <button class="btn btn-danger btn-sm fs-xsmall @if(!auth()->user()->banner) d-none @endif" title="Delete Banner" type="{{ (!auth()->user()->banner) ? 'button' : 'submit' }}" onclick="load()"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>

                        <p class="form-label text-gray fs-small">Allowed Formats: JPEG, PNG. Max size: 6mb. Optimal dimensions: 1700x330</p>
                        
                        <form action="{{ route('banner') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="box-banner mb-3">
                                <label for="banner" class="drag-area-banner pointer">
                                    <div class="icon">
                                      <i class="fas fa-images"></i>
                                    </div>
                            
                                    <span class="header-banner">Drag & Drop or <span class="button-banner">browse</span></span>
                                    <span class="support">Supports: JPEG, JPG, PNG</span>
                                </label>
                                <input type="file" hidden id="banner" name="banner"/>
                            </div>
                            <div class="d-flex justify-content-center d-none" id="banner-save">
                                <button class="btn btn-primary btn-sm px-5" id="btn-save" onclick="load()"><i class="fa-solid fa-floppy-disk"></i> Change Banner</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="errorImage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto text-danger" id="error-image"><i class="fa-solid fa-circle-exclamation"></i> This is not an Image File</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="invalidImage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto text-danger error-image">
          <i class="fa-solid fa-circle-exclamation"></i> 
          @error('avatar') {{ $message }} @enderror
          @error('banner') {{ $message }} @enderror
      </strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="/js/user.js"></script>
@error('avatar')
    <script>
        $(document).ready(function () {
            $('#invalidImage').toast('show');
        });
    </script>
@enderror
@error('banner')
    <script>
        $(document).ready(function () {
            $('#invalidImage').toast('show');
        });
    </script>
@enderror

@if (session()->has('avatarSuccess'))
<script>
    $( document ).ready(function() {
        $("#errorImage").toast('show');
        $("#error-image").removeClass("text-danger");
        $("#error-image").addClass("text-success");
        $("#error-image").html('<i class="fa-solid fa-circle-check"></i> Avatar successfully changed');
    });
</script>
@endif

@if (session()->has('bannerSuccess'))
<script>
    $( document ).ready(function() {
        $("#errorImage").toast('show');
        $("#error-image").removeClass("text-danger");
        $("#error-image").addClass("text-success");
        $("#error-image").html('<i class="fa-solid fa-circle-check"></i> Banner successfully changed');
    });
</script>
@endif

@if (session()->has('deleteSuccess'))
<script>
    $( document ).ready(function() {
        $("#errorImage").toast('show');
        $("#error-image").removeClass("text-danger");
        $("#error-image").addClass("text-success");
        $("#error-image").html('<i class="fa-solid fa-trash"></i> Successfully deleted');
    });
</script>
@endif

@if (session()->has('deleteFailed'))
<script>
    $( document ).ready(function() {
        $("#errorImage").toast('show');
        $("#error-image").removeClass("text-success");
        $("#error-image").addClass("text-danger");
        $("#error-image").html('<i class="fa-solid fa-circle-exclamation"></i> Failed deleted');
    });
</script>
@endif

<script src="{{ url('/js/drop.js') }}"></script> 
@endsection