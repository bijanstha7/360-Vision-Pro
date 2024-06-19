<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <title> @yield('title') | 360 Video</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/Banvaayi-favicon.png') }}">
    @stack('styles')
    @include('layouts.header.head-css')


</head>



@show
<!-- Begin page -->
<div id="layout-wrapper">
    @auth
        @include('layouts.topbar')
    @endauth
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class=" main-content @if(!Auth::user()) ms-0 @endif">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
{{--@include('layouts.right-sidebar')--}}
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
</body>

</html>
