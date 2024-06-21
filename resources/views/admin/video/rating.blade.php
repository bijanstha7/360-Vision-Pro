@extends('layouts.admin')
@section('title', 'Rating')
@section('css')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 41px;
  height: 16px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 17px;
}

.slider.round:before {
  border-radius: 50%;
}
#variations-list {
    list-style-type: none;
    padding: 0;
}

#variations-list li {
    background-color: #f4f4f4;
    border: 1px solid #ddd;
    margin: 5px 0;
    padding: 10px;
}
.review-rating .star {
      font-size: 20px;
      color: lightgray;
  }

  .review-rating .star.filled {
      color: gold;
  }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Rating of <span class="badge badge-pill badge-soft-success">{{ $video->title }}</span></h4> 
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Rating</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="w-100">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-4">
            <div class="card p-4 rounded cShadow table-responsive">
           
                <table class="table table-bordered  table-hover dt-responsive display nowrap">
                    <thead>
                        <tr>
                            <th>Visual Quality Experience</th>
                            <th>Streaming Quality</th>
                            <th>User Interface (UI) and Navigation</th>
                            <th>Overall Rating</th>
                            <th>User Opinion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($ratings))
                            <tr>
                                <td colspan="3">No Feedback Found</td>
                            </tr>
                        @else
                            @foreach ($ratings as $rating)
                            <tr>
                                <td>
                                  <div class="review-rating">
                                      @for ($i = 1; $i <= 5; $i++)
                                          <span class="star {{ $i <= $rating->r1 ? 'filled' : '' }}">★</span>
                                      @endfor
                                  </div>
                                </td>
                                <td>
                                  <div class="review-rating">
                                      @for ($i = 1; $i <= 5; $i++)
                                          <span class="star {{ $i <= $rating->r2 ? 'filled' : '' }}">★</span>
                                      @endfor
                                  </div>
                                </td>
                                <td>
                                  <div class="review-rating">
                                      @for ($i = 1; $i <= 5; $i++)
                                          <span class="star {{ $i <= $rating->r3 ? 'filled' : '' }}">★</span>
                                      @endfor
                                  </div>
                                </td>
                                <td>
                                  <div class="review-rating">
                                      @for ($i = 1; $i <= 5; $i++)
                                          <span class="star {{ $i <= $rating->rating ? 'filled' : '' }}">★</span>
                                      @endfor
                                  </div>
                                </td>
                                <td>{{ $rating->comment }}</td>
                            </tr>
                            @endforeach
                            
                        @endif
                    </tbody>
                </table>
                @if (empty($ratings))
                    
                @else
                    {{ $ratings->links() }}
                @endif
            </div>
            <a href="{{ route('download.rating', $video->id) }}" class="btn btn-primary mb-3">Download Video Ratings</a>
            <!-- <a href="/download-csv" class="btn btn-primary">Download Rating</a> -->
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@endsection