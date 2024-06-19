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
