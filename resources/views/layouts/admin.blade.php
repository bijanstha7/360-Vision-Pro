<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <title> @yield('title') | 360 Vision Pro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/Banvaayi-favicon.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
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
