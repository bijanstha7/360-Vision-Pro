<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('/home_assets/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@44659d9/css/all.min.css" rel="stylesheet" type="text/css" />
    <title>360 Vision Pro</title>
    <style>
        .slider-container {
            display: flex;
            align-items: center;
            width: 100%;
            margin: auto;
        }

        .category-slider {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            background-color: #ffffff;
            padding: 10px 0;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
            border-radius: 8px;
            flex-grow: 1;
            scroll-behavior: smooth;
        }

        .category {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 5px;
            background-color: #e0e0e0;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .category:hover {
            background-color: #d0d0d0;
        }

        .category:active {
            background-color: #c0c0c0;
        }

        .category-slider::-webkit-scrollbar {
            display: none;
        }

        .category-slider {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .slider-icon {
            background-color: #ffffff;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            padding: 10px;
            margin: 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-icon i {
            font-size: 20px;
        }

        .slider-icon:hover {
            background-color: #f0f0f0;
        }
        .category {
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .category.default {
            background-color: black;
            color: white;
        }

        .category.selected {
            background-color: black;
            color: white;
        }
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
    @include('home.nav')
    
<!-- Main Body -->
<div class="slider-container">
        <div class="slider-icon left" onclick="scrollCategoriesLeft()">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                <path d="M0 0h24v24H0V0z" fill="none"/>
                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
            </svg>
        </div>
        <div class="category-slider" id="categorySlider">
            <div class="category selected" id="all_category" onclick="filterVideos(0)">All</div>
            @foreach ($categories as $category)
                <div class="category" id="category-{{ $category->id }}" onclick="filterVideos({{ $category->id }})">{{ $category->name }}</div>
            @endforeach
        </div>
        <div class="slider-icon right" onclick="scrollCategoriesRight()">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                <path d="M0 0h24v24H0V0z" fill="none"/>
                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/>
            </svg>
        </div>
    </div>
    <div class="banner">
        <img src="{{ URL::asset('home_assets/images/banner.png') }}" alt="" srcset="">
    </div>
    <div class="container-fluid" id="videoListContainer">
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
<script>
        let currentCategoryId = 0;

        function scrollCategoriesLeft() {
            const slider = document.getElementById('categorySlider');
            slider.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        }

        function scrollCategoriesRight() {
            const slider = document.getElementById('categorySlider');
            slider.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        }

        function filterVideos(categoryId = currentCategoryId) {
            currentCategoryId = categoryId;
            const searchQuery = $('#searchInput').val();

            document.querySelectorAll('.category').forEach(category => {
                category.classList.remove('selected');
            });

            if (categoryId == 0) {
                document.querySelector('#all_category').classList.add('selected');
            } else {
                document.getElementById('category-' + categoryId).classList.add('selected');
            }
            if (categoryId != 0) {
                document.querySelector('#all_category').classList.remove('selected');
            }
            $.ajax({
                url: '/filter-videos',
                method: 'GET',
                data: { category_id: categoryId},
                success: function(response) {
                    $('#videoListContainer').html(response);
                }
            });
        }

        function filterVideosBySearch() {
            const searchQuery = $('#searchInput').val();
            $.ajax({
                url: '/filter-videos',
                method: 'GET',
                data: { search_query: searchQuery },
                success: function(response) {
                    $('#videoListContainer').html(response);
                }
            });
        }

        function handleSearchKey(event) {
            if (event.key === 'Enter') {
                filterVideosBySearch();
            }
        }
    </script>
</body>
</html>