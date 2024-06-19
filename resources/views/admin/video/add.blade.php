@extends('layouts.admin')
@section('title', 'Videos')
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
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Videos</h4>
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Videos</li>
                    <li class="breadcrumb-item active">Add New Video</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="w-100">
    <div class="row justify-content-center">
        <div class="card p-4 rounded cShadow container-fluid">
           <form action="{{ route('videos.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                    <label for="">Title<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="text" class="form-control" name="title" placeholder="Enter Title">
                    </div>
                </div>
                
                <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                    <label for="">Category<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select class="form-control" required name="category_id" id="" placeholder="Select Category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
               


                <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                    <label for="">Thumbnail<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="file" class="form-control" name="thumbnail" accept="image/*">
                    </div>
                </div>
                <!-- <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                    <label for="">Video Type<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select class="form-control" required name="video_type" id="" placeholder="Select Video Type">
                            <option value="">Select Video Type</option>
                            <option value="Original">Original</option>
                            <option value="Enhanced">Enhanced</option>
                        </select>
                    </div>
                </div> -->
                <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                    <label for="">Original Video<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="file" class="form-control" name="video" accept="video/*">
                    </div>
                </div>
                <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                    <label for="">Enhanced Video<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="file" class="form-control" name="enhanced_video" accept="video/*">
                    </div>
                </div>
                <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                    <label for="">Video Resolution<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="text" class="form-control" name="resolution" placeholder="Enter Video REsolution">
                    </div>
                </div>
                <div class="form-group col-12 mb-2">
                    <label for=""> Description<span class="text-danger">*</span></label>
                    <div class="">
                        <textarea class="form-control" id="tinmceEditor" name="description" cols="30"
                            rows="10">
                        </textarea>
                    </div>
                    <span id="editorValidate" class="text-danger"></span>
                </div>
                <div class="form-group col-sm-6 col-md-6 col-lg-6 col-xl-2 ml-5">
                    <label for="switch4" data-on-label="Yes" data-off-label="No">
                        <label for="">Trending: </label>
                        <div class="form-check form-switch form-switch-lg " dir="ltr">

                            <input class="form-check-input" name="trending" type="checkbox" id="SwitchCheckSizelg">
                        </div>
                    </label>
                </div>
                
                <div class="form-group col-sm-6 col-md-6 col-lg-6 col-xl-2 ml-5">
                    <label for="switch4" data-on-label="Yes" data-off-label="No">
                        <label for="">Status: </label>
                        <div class="form-check form-switch form-switch-lg " dir="ltr">

                            <input class="form-check-input" name="status" type="checkbox" id="SwitchCheckSizelg">
                        </div>
                    </label>
                </div>
                <div class="form-group col-sm-12 mb-2">
                    <button id="submit-btn" class="btn btn-primary btn-sm">Submit</button>
                </div>
                
            </div>
           </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.tiny.cloud/1/{{env('TINY_MCE_KEY')}}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
<script>

    $('textarea#tinmceEditor').tinymce({
        height: 500,
  
        plugins: [
          'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
          'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
          'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic backcolor | ' +
          'alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist outdent indent | removeformat | help'
    });

    $(document).ready(function () {
        

        var submitBtn = $('#submit-btn');
        $('form').submit(function () {
            var editorContent = $('textarea#tinmceEditor').val();
            if (editorContent.trim() === '') {
                $('#editorValidate').text('Please enter product description');
                return false; 
            } else {
                $('#editorValidate').text('');
                submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');
                submitBtn.prop('disabled', true);
            }
            
        });
    });

    
</script>
@endsection