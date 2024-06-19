<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('/home_assets/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://vjs.zencdn.net/5.10.4/video-js.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/yanwsh/videojs-panorama/master/dist/videojs-panorama.css">
    <title>Profile | 360 Video</title>
    <style>
        .review {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .review-user-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .review-rating .star {
            font-size: 20px;
            color: gold;
        }

        .review-rating .star.filled {
            color: gold;
        }

        .review-rating .star {
            color: lightgray;
        }

        .player-wrapper {
            position: relative;
            width: 100%;
            height: 100vh;
            
            .player {
                position: absolute; 
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
            }
        }
        .player-dimensions{
            
        width: 100%;
        height: 100%;

        }
        .video-js .vjs-tech{
            position: static;
        }


    </style>
</head>
<body>
    
    <nav class="flex-div">
        <div class="nav-left flex-div">
            <a href="{{route('home')}}"><img src="{{ URL::asset('home_assets/images/logo1.png') }}" class="logo" alt="" srcset=""></a>
        </div>
        
        <div class="nav-right flex-div">
            
        </div>
    </nav>



<!-- Main Body -->
<div class="container-fluid">
    <div class="row mt-4">
        @if ($video->video_type == 'Enhanced')
        <div class="col-lg-6 col-md-12 col-sm-6">
            <video id="player_orig" class="player video-js vjs-default-skin vjs-big-play-centered" crossorigin="anonymous" preload="metadata" style="width:660px;height:500px" autoplay controls>
                <source poster="https://raw.githubusercontent.com/Pierrinho/elephant/master/elephant.jpg" src="/{{ htmlentities($video->video) }}">
            </video>
            <h4 style="text-align:center;">Original Video</h4>
        </div>  
        <div class="col-lg-6 col-md-12 col-sm-6">
            <video id="player" class="player video-js vjs-default-skin vjs-big-play-centered" crossorigin="anonymous" preload="metadata" style="width:660px;height:500px" autoplay controls>
                <source poster="https://raw.githubusercontent.com/Pierrinho/elephant/master/elephant.jpg" src="/{{ htmlentities($video->enhanced_video) }}">
            </video>
            <h4 style="text-align:center;">Enhanced Video</h4>
        </div>
        @else
            <div class="col-lg-6 col-md-12 col-sm-6">
                <video id="player" class="player video-js vjs-default-skin vjs-big-play-centered" crossorigin="anonymous" preload="metadata" style="width:660px;height:500px" autoplay controls>
                    <source poster="https://raw.githubusercontent.com/Pierrinho/elephant/master/elephant.jpg" src="/{{ htmlentities($video->video) }}">
                </video>
            </div>    
        @endif
        <div class="col-md-8 col-lg-8 col-sm-12">
            <h3> {{ $video->title }}</h3>
            <hr>
            <div class="owner">
                <img src="{{ isset($video->user->profile_img) ? asset('profile_photos/'.$video->user->profile_img) : asset('/assets/images/users/avatar-9.png') }}">
                <div>
                    <p>{{ $video->user->name }}</p>
                </div>
            </div>
            <p>
                {!! $video->description !!}
            </p>

            <div class=" pt-4">
                
                
                
                
                <form id="review-form">
                    
                    @if ($video->video_type == 'Enhanced')
                        <h1>Feedback</h1>
                        <p>Please provide feedback Based on your video quality Experience</p>
                        <p> ⭐ 1 star: Poor </p>
                        <p> ⭐⭐ 2 stars: Fair or Below Average</p>
                        <p> ⭐⭐⭐ 3 stars: Average or Good</p>
                        <p> ⭐⭐⭐⭐ 4 stars: Very Good or Excellent</p>
                        <p> ⭐⭐⭐⭐⭐ 5 stars: Outstanding or Exceptional</p>

                        <label style="font-weight:bold;">Visual Quality Experience:</label>
                        <label class=" star star-detail">
                            <input type="radio" id="r1" name="rating" value="5">
                            <label for="r1"></label>
                            <input type="radio" id="r2" name="rating" value="4">
                            <label for="r2"></label>
                            <input type="radio" id="r3" name="rating" value="3">
                            <label for="r3"></label>
                            <input type="radio" id="r4" name="rating" value="2">
                            <label for="r4"></label>
                            <input type="radio" id="r5" name="rating" value="1">
                            <label for="r5"></label>
                        </label>
                        <br>
                        <label style="font-weight:bold;">Streaming Quality</label>
                        <label class=" star star-detail">
                            <input type="radio" id="q1" name="quality" value="5">
                            <label for="q1"></label>
                            <input type="radio" id="q2" name="quality" value="4">
                            <label for="q2"></label>
                            <input type="radio" id="q3" name="quality" value="3">
                            <label for="q3"></label>
                            <input type="radio" id="q4" name="quality" value="2">
                            <label for="q4"></label>
                            <input type="radio" id="q5" name="quality" value="1">
                            <label for="q5"></label>
                        </label>
                        <br>
                        <label style="font-weight:bold;" >User Interface (UI) and Navigation:</label>
                        <label class="star star-detail">
                            <input type="radio" id="e1" name="engagement" value="5">
                            <label for="e1"></label>
                            <input type="radio" id="e2" name="engagement" value="4">
                            <label for="e2"></label>
                            <input type="radio" id="e3" name="engagement" value="3">
                            <label for="e3"></label>
                            <input type="radio" id="e4" name="engagement" value="2">
                            <label for="e4"></label>
                            <input type="radio" id="e5" name="engagement" value="1">
                            <label for="e5"></label>
                        </label>
                        <br>
                    @endif
                    
                    <div class="py-3">
                        <h1>Opinion</h1>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                    <input type="hidden" name="video_id" value="{{ $video->id }}">
                    <div id="error-messages" style="color: red;"></div>
                    <button type="submit" class="btn btn-lg btn-warning">Submit</button>
                </form>
            </div>

            <div class="mt-5">
                <h2>Users Opinion</h2>
                <div id="reviews-container"></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 mt-4 pt-4">
            @if (empty($recommendations))
                
            @else
                @foreach ($recommendations as $recommendation)
                    <div class="side-video-list">
                        <a href="{{ route('playVideo', $recommendation->slug) }}" class="small-thumbnail"> <img src="/{{ htmlentities($recommendation->thumbnail) }}" alt="" srcset=""></a>
                        <div class="vid-info">
                            <a href="{{ route('playVideo', $recommendation->slug) }}">{{ $recommendation->title }}</a>
                            <p>{{ $recommendation->user->name }}</p>
                            <p>{{ $recommendation->comments_count }} Comments</p>
                            <div class="review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $recommendation->average_rating ? 'filled' : '' }}">★</span>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://vjs.zencdn.net/5.10.4/video.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r76/three.js"></script>
<script src="https://rawgit.com/yanwsh/videojs-panorama/master/dist/videojs-panorama.v5.js"></script>
<script>
    var options = {
    plugins: {
        panorama: {
        clickAndDrag: true,
        clickToToggle: true,
        autoMobileOrientation: true,
        backToVerticalCenter: false,
        backToHorizonCenter: false
        }
    }
    };
    @if ($video->video_type == 'Enhanced')
        var player = videojs('player_orig', options, function() {

        });
    @endif
    
    var player = videojs('player', options, function() {

    });
</script>
<script>
    


    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function fetchReviews() {
            $.ajax({
                url: '/reviews/{{ $video->id }}',
                method: 'GET',
                success: function (reviews) {
                    let reviewsHtml = '';
                    reviews.forEach(review => {
                        const profileImg = '/assets/images/users/avatar-9.png';
                        reviewsHtml += `
                            <div class="review">
                                <div class="review-header">
                                    <img src="${profileImg}" alt="Guest" class="review-user-picture rounded-circle">
                                    <strong>Guest</strong>
                                </div>
                                <div class="review-rating">
                                    ${renderStars(review.rating)}
                                </div>
                                <p>${review.comment}</p>
                            </div>
                        `;
                    });
                    if (reviewsHtml == '') {
                        $('#reviews-container').html('No reviews found');
                    } else {
                        $('#reviews-container').html(reviewsHtml);
                    }
                    
                }
            });
        }

        function renderStars(rating) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += i <= rating ? '<span class="star filled">★</span>' : '<span class="star">☆</span>';
            }
            return starsHtml;
        }


        $('#review-form').on('submit', function (e) {
            e.preventDefault();

            let hasError = false;
            let errorMessages = [];

            const rating = $('input[name="rating"]:checked').val();
            const quality = $('input[name="quality"]:checked').val();
            const engagement = $('input[name="engagement"]:checked').val();
            const comment = $('#comment').val();

            @if ($video->video_type == 'Enhanced')
                if (!rating || !quality || !engagement) {
                    hasError = true;
                    errorMessages.push("Please select all ratings.");
                }
            @endif
            

            if (!comment) {
                hasError = true;
                errorMessages.push("Please enter a comment.");
            }

            if (hasError) {
                $('#error-messages').html(errorMessages.join('<br>'));
            } else {
                $.ajax({
                    url: '{{ route("reviews.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.warning) {
                            $('#error-messages').html('');
                            Toast.fire({
                                icon: 'warning',
                                title: response.warning
                            });
                            // $('#error-messages').html(response.warning);
                        } else {
                            Toast.fire({
                                icon: 'success',
                                title: response.success
                            });
                            fetchReviews();
                            $('#comment').val('');
                            $('input[name="rating"]').prop('checked', false);
                            $('input[name="quality"]').prop('checked', false);
                            $('input[name="engagement"]').prop('checked', false);
                            $('#error-messages').html('');
                        }
                    },
                    error: function (response) {
                        $('#error-messages').html('An error occurred. Please try again.');
                    }
                });
            }
        });

        fetchReviews();
    });
</script>
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