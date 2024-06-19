
@yield('css')

<!-- Bootstrap Css -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="{{ URL::asset('/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/css/main.css') }}" rel="stylesheet" type="text/css" />

<!-- Icons Css -->
<link href="{{ URL::asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@44659d9/css/all.min.css" rel="stylesheet" type="text/css" />