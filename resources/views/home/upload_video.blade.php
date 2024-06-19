<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('/home_assets/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>360 Vision Pro</title>
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
</head>
<body>
  @include('home.nav')
<!-- Main Body -->
<div class="container">
    <div class="row justify-content-center">
        <div class="card p-4 rounded cShadow container-fluid">
            <h2 class="py-2">Upload Video</h2>
           <form action="{{ route('upload.video') }}" method="post" enctype="multipart/form-data">
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
                <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                    <label for="">Video<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input required type="file" class="form-control" name="video" accept="video/*">
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
                <div class="form-group col-sm-6 col-md-6 col-lg-6 col-xl-6 ml-5">
                    <label for="switch4" data-on-label="Yes" data-off-label="No">
                        <label for="">Trending: </label>
                        <div class="form-check form-switch form-switch-lg " dir="ltr">

                            <input class="form-check-input" name="trending" type="checkbox" id="SwitchCheckSizelg">
                        </div>
                    </label>
                </div>
                
                <div class="form-group col-sm-6 col-md-6 col-lg-6 col-xl-6 ml-5">
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
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.tiny.cloud/1/{{env('TINY_MCE_KEY')}}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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