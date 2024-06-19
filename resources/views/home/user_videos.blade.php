<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('/home_assets/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>360 Vision</title>
    <style>
        .review-user-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .review-rating .star {
            font-size: 20px;
            color: lightgray;
        }

        .review-rating .star.filled {
            color: gold;
        }
    </style>
</head>
<body>
    
    <nav class="flex-div">
        <div class="nav-left flex-div">
            <!-- <img src="{{ URL::asset('home_assets/images/menu.png') }}" class="menu-icon" alt="" srcset=""> -->
            <a href="{{route('home')}}"><img src="{{ URL::asset('home_assets/images/logo1.png') }}" class="logo" alt="" srcset=""></a>
            
        </div>
        
        <div class="nav-right flex-div">
            <a href="{{route('uploadVideo')}}"><img src="{{ URL::asset('home_assets/images/upload.png') }}" alt="" srcset=""></a>
            <a href="{{route('userVideos')}}"><img src="{{ URL::asset('home_assets/images/more.png') }}" alt="" srcset=""></a>

            @if (!Auth::user())
                <a class="btn btn-success mx-2" href="{{route('register')}}">Register</a>
                <a class="btn btn-success mx-2" href="{{route('login')}}">Login</a>
            @else
               <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->profile_img) ? asset('profile_photos/' . Auth::user()->profile_img) : asset('/assets/images/users/avatar-9.png') }}" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a href="{{route('profile')}}" class="dropdown-item"><i class="bx bx-cog font-size-16 align-middle me-1"></i> <span key="t-my-wallet">Profile</span></a>
                            <a href="{{route('userVideos')}}" class="dropdown-item"><i class="bx bx-cog font-size-16 align-middle me-1"></i> <span key="t-my-wallet">Your Videos</span></a>
                            <a class=" logout-form dropdown-item text-danger" href="javascript:void();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                            <form action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
    </nav>



<!-- Main Body -->
<div class="container-fluid">
    <div class="banner">
        <img src="{{ URL::asset('home_assets/images/banner.png') }}" alt="" srcset="">
    </div>
    <div class="container-fluid">
        @if (empty($videos))
            <div class="card text-center my-4">
                <p class="text-center py-4">No videos found</p>
            </div>
        @else
        <div class="row">
            @foreach ($videos as $video)
                <div class="col-sm-6 col-md-3 col-lg-3 vid-list my-3">
                    <a href="{{ route('playVideo', $video->slug) }}"><img src="/{{ htmlentities($video->thumbnail) }}" class="thumbnail"></a>
                    <div class="flex-div">
                        <img src="{{ isset($video->user->profile_img) ? asset('profile_photos/'.$video->user->profile_img) : asset('/assets/images/users/avatar-9.png') }}" class="review-user-picture rounded-circle">
                        <div class="vid-info">
                            <a href="{{ route('playVideo', $video->slug) }}">{{ $video->title }}</a>
                            <p>{{ $video->user->name }}</p>
                            <p>{{ $video->comments_count }} Comments</p>
                            <div class="review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $video->average_rating ? 'filled' : '' }}">★</span>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @endif
        
        
    </div>



</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
   
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false,
        timer: 5000,
        showCloseButton: true,
        //timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    @if(session()->has('success'))
    Toast.fire({
        icon: 'success',
        title: '{{ session()->get('success') }}'
    })
    @endif
    @if(session()->has('warning'))
    Toast.fire({
        icon: 'warning',
        title: '{{ session()->get('warning') }}'
    })
    @endif

</script>
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
</body>
</html>