<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('/home_assets/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Profile | 360 Vision Pro</title>
</head>
<body>
    @include('home.nav')
<!-- Main Body -->
<div class="container">
    <div class="row">
        <div class="col-12 card p-4 rounded cShadow">
        <h2 class="py-2">Edit Profile</h2>
        <form action="{{ route('editProfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="row">
                <div class="row">
                    <div class="form-group col-sm-12 mb-2 col-md-6 col-lg-6 col-xl-6">
                        <label for=""> Name :</label>
                        <input required type="text" name="name" value="{{ !is_null($user->name) ? $user->name : '' }}" class="form-control">
                        @if ($errors->has('name'))
                        <span class="text-danger ml-2">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-sm-12 mb-2 col-md-6 col-lg-6 col-xl-6">
                        <label for=""> Email :</label>
                        <input readonly type="email" name="email" value="{{ !is_null($user->email) ? $user->email : '' }}" class="form-control">
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-12 mb-2 col-md-6 col-lg-6 col-xl-6">
                        <label for="">New Password :</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>



                    <div class="form-group col-sm-12 mb-2 col-md-6 col-lg-6 col-xl-6">
                        <label for="">Confirm Password :</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="current-password">
                        @if ($errors->has('password'))
                        <span class="text-danger ml-2">{{ $errors->first('confirm_password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 mb-2 col-md-6 col-lg-6 col-xl-6">
                        <label for=""> Profile Image :</label>
                        <input type="file" name="profile_img" value="{{ !is_null($user->profile_img) ? $user->profile_img : '' }}" class="form-control">
                        @if ($errors->has('profile_img'))
                        <span class="text-danger ml-2">{{ $errors->first('profile_img') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-sm-12 mb-2 col-md-3 col-lg-3 col-xl-3">
                        <img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->profile_img) ? asset('profile_photos/'.Auth::user()->profile_img) : asset('/assets/images/users/avatar-9.png') }}" style="width:100px;height:100px;" alt="Header Avatar">
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-12 mb-2 col-md-3 col-lg-3 col-xl-3">
                <button type="submit" value="Save Settings" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> Save Settings</button>
            </div>
        </form>
    </div>
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