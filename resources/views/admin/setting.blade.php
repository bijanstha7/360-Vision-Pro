@extends('layouts.admin')
@section('title', 'Settings')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@20.1.0/build/css/intlTelInput.css">
<style>
    .intl-tel-input,
    .iti{
    width: 100%;
    }
    .form-check-container {
        display: flex;
        align-items: center;
    }

    .form-check {
        margin-right: 20px; /* Adjust as needed */
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Settings</h4>
            {{-- {{ $errors }} --}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                    {{-- <li class="breadcrumb-item active">Orders</li> --}}
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="w-100">

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card p-4 rounded cShadow">

                <form action="{{ route('settings.edit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                            <label for=""> Name :</label>
                            <input required type="text" name="name" value="{{ !is_null($user->name) ? $user->name : '' }}" class="form-control">
                            @if ($errors->has('name'))
                            <span class="text-danger ml-2">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 mb-2 col-md-3 col-lg-3 col-xl-3">
                                <label for="">New Password :</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>



                            <div class="form-group col-sm-12 mb-2 col-md-3 col-lg-3 col-xl-3">
                                <label for="">Confirm Password :</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="current-password">
                                @if ($errors->has('password'))
                                <span class="text-danger ml-2">{{ $errors->first('confirm_password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 mb-2 col-md-3 col-lg-3 col-xl-3">
                                <label for=""> Profile Image :</label>
                                <input type="file" name="profile_img" value="{{ !is_null($user->profile_img) ? $user->profile_img : '' }}" class="form-control">
                                @if ($errors->has('profile_img'))
                                <span class="text-danger ml-2">{{ $errors->first('profile_img') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-sm-12 mb-2 col-md-3 col-lg-3 col-xl-3">
                                <img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->profile_img) ? asset('profile_photos/'.Auth::user()->profile_img) : asset('/assets/images/users/avatar-9.png') }}" style="width:100px;height:100px;" alt="Header Avatar">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 mb-2 col-md-3 col-lg-3 col-xl-3">
                        <button type="submit" value="Save Settings" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> Save Settings</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>


</div>
</div>

@endsection