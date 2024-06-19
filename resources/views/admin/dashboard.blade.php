@extends('layouts.admin')
@section('title')
{{ 'Dashboard' }}
@endsection
@section('css')

@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-sm-6 col-md-3 col-lg-3">
                <a href="{{ route('admins.index') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-white bg-soft text-primary font-size-18">
                                        <i class="fas fa-users fa-2x me-2 text-primary"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">TOTAL ADMINS</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>{{ $total_admins }}</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <a href="{{ route('users.index') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-white bg-soft text-primary font-size-18">
                                        <i class="fas fa-users fa-2x me-2 text-primary"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">TOTAL USERS</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>{{ $total_users }}</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <a href="{{ route('category.index') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-white bg-soft text-primary font-size-18">
                                        <i class="fas fa-store fa-2x me-2 text-primary"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">TOTAL CATEGORIES</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>{{ $total_categories }}</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <a href="{{ route('videos.index') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-white bg-soft text-primary font-size-18">
                                        <i class="bx bx-video fa-2x me-2 text-primary"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">TOTAL VIDEOS</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>{{ $total_videos }}</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')



@endsection