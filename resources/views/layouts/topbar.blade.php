

<body data-sidebar="dark" class="" style="">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box pt-2">
                        <div class="logo logo-dark">
                            <span class="logo-sm">
                                <!-- <p class='small_logo_e'> <img src="{{ URL::asset('assets/images/logo/logo_main.png') }}"> </p> -->
                            </span>
                            <span class="logo-lg">
                                <!-- <img src="{{ URL::asset('/logo/logo.png') }}" style="height:50px;margin:auto;padding-top:10px;" /> -->
                            </span>
                        </div>
                        <div class='logo logo-light'>
                            <span class="logo-sm">
                                <!-- <p class='small_logo_e'> 360 Video</p> -->
                            </span>
                            <span class="logo-lg ">
                                <h3 class="pt-4 text-primary">360 Vision Pro</h3>
                            </span>    
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    
                    <!-- App Search-->
                </div>
                <div class="d-flex justify-content-center">
                        <div class="pt-3 text-center" style="position: relative;">
                            <h5 class="text-primary">Welcome Back <b>{{ Auth::user()->name }}</b></h5>
                        </div>
                    </div>

                @if (Auth::user()->status == '0')
                <label style="font-size: 20px;" class="text-danger" for="">Your status has been temporarily blocked, Please Contact Support</label>
                @endif

                <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->profile_img) ? asset('profile/' . Auth::user()->profile_img) : asset('/assets/images/users/avatar-9.png') }}" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ ucfirst(Auth::user()->name) }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a href="{{ route('setting') }}" class="dropdown-item"><i class="bx bx-cog font-size-16 align-middle me-1"></i> <span key="t-my-wallet">Settings</span></a>
                            <a class=" logout-form dropdown-item text-danger" href="javascript:void();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                            <form action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar="init" class="h-100">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" style="height: 100%; padding-right: 0px; padding-bottom: 0px; overflow: hidden;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    <!--- Sidemenu -->
                                    @if (Auth::user()->status == 1)
                                        <div id="sidebar-menu" class="mm-active">
                                            <!-- Left Menu Start -->
                                            <ul class="metismenu list-unstyled mm-show" id="side-menu">
                                                <li class="menu-title" key="t-menu">main Menu</li>

                                                <li class="{{ (Request::is('admin') || Request::is('fundraiser') || Request::is('member')) ? 'active' : '' }}">
                                                    <a class="{{ (Request::is('admin') || Request::is('fundraiser') || Request::is('member')) ? 'waves-effect active' : 'waves-effect' }}" href="{{ route('dashboard') }}" id="topnav-dashboard" role="button">
                                                        <i class="bx bx-home-circle me-2" style="
                                                            {{ 
                                                                (Request::is('admin') || Request::is('fundraiser') || Request::is('member')) 
                                                                ? 'color: #fff!important;' 
                                                                : '' 
                                                            }}
                                                        "></i>
                                                        <span key="t-dashboards">Dashboard</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="{{ Request::is('category') ? 'waves-effect' : '' }}" href="{{ route('category.index') }}" key="t-products"> 
                                                        <i class="bx bx-store" style="{{ Request::is('category') ? 'color: #fff!important;' : '' }}"></i>
                                                        <span key="t-dashboards">Categories</span> 
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="{{ Request::is('videos') ? 'waves-effect' : '' }}" href="{{ route('videos.index') }}" key="t-products"> 
                                                        <i class="bx bx-video" style="{{ Request::is('videos') ? 'color: #fff!important;' : '' }}"></i>
                                                        <span key="t-dashboards">Videos</span> 
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a class="{{ Request::is('admins') ? 'waves-effect' : '' }}" href="{{ route('admins.index') }}" key="t-products"> 
                                                        <i class="fas fa-users" style="{{ Request::is('admins') ? 'color: #fff!important;' : '' }}"></i>
                                                        <span key="t-dashboards">Admins</span> 
                                                    </a>
                                                </li>
                                                <li class="menu-title" key="t-menu">SETTINGS </li>
                                                <li class="mm-active">
                                                    <a class="waves-effect" href="{{ route('setting') }}" id="topnav-dashboard" role="button">
                                                        <i class="bx bxs-cog me-2" style="
                                                            {{ 
                                                                (Request::is('admin/setting')) 
                                                                ? 'color: #fff!important;' 
                                                                : '' 
                                                            }}
                                                        "></i>
                                                        <span key="t-dashboards">Settings</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="logout-form waves-effect" href="javascript:void();"><i class="bx bxs-log-out me-2"></i> <span key="t-logout">Logout</span></a>
                                                    <form action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    <!-- Sidebar -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: auto; height: 126px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;">
                    </div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="height: 572px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
                </div>
            </div>
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- END layout-wrapper -->
</body>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
    $(document).ready(function() {
        $(".logout-form").click(function(e) {
            e.preventDefault();
            const form = $(this).next('form');
            // console.log(form)
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Do you want to Log Out?",
                // text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes , Logout Me.",
                cancelButtonText: "No , Cancel it.",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    // Perform the form submission to delete the record
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancellation if needed
                }
            });
        });
    });
</script>