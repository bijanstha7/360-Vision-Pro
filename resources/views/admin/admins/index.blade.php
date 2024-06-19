@extends('layouts.admin')
@section('title', 'Admins ')
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
            <h4 class="mb-sm-0 font-size-18">Admins </h4>
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Admins </li>
                </ol>
                <button type="button" class="btn btn-primary mt-2" href="javascript:void(0)" id="createNewAdmin">
                    <i class="fa fa-plus"></i> Add New Admin
                </button>
            </div>
        </div>
    </div>
</div>
<div class="card">
  
    <div class="card-body">
        
            <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="email">Seach By Name :</label>
                    <input type="text" name="filter_name" class="form-control" id="filter_name"  placeholder="Search by Name" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="email">Seach By Email :</label>
                    <input type="email" name="filter_email" class="form-control" id="filter_email"  placeholder="Search by Email" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="dob">Search By Status : </label>
                    <select name="filter_status" class="filter_status form-control" id="exampleFormControlSelect1">
                        <option value="">Select Status</option>
                        <option value="1" >Active</option>
                        <option value="0" >InActive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                     <button type="button" class="btn btn-lg btn-primary mt-4 float-right button-spinner search_btn">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
            </div>
    
    </div>
</div>
<div class="w-100">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-4">
            <div class="card p-4 rounded cShadow table-responsive">
                <table id="datatable" class="table table-bordered  table-hover dt-responsive display nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Model -->
<div style="top: 5%;" class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="FundraiserForm" name="FundraiserForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input required type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                            <span id="nameError" class="error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input required type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="50" required="">
                            <span id="emailError" class="error"></span>
                        </div>
                    </div>
                    <div id="fundraiser_password" class="form-group">
                        <label for="name" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-12">
                            <input required type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="" maxlength="50" required="">
                            <span id="passwordError" class="error"></span>
                        </div>
                    </div>

                    <div class="form-group pt-2">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="custom-control custom-switch" bis_skin_checked="1">
                            <label class="switch">
                                <input id="status" name="status" class="time_toggle" value="1" type="checkbox"><span class="slider round"></span>
                                <label class="custom-control-label" style="padding-left: 50px;" for="group_status">Active</label>
                            </label>
                            
                        </div>
                    </div>  
                    
                    <div class="modal-footer py-1">
                        <button id="closeModalBtn" type="button" class="btn btn-outline-primary">Close</button>
                        <button type="submit" class="btn btn-primary button-spinner" id="saveBtn" value="create">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $('.search_btn').on('click', function() {
        table.draw();
    });
    var table = $('#datatable').DataTable({
        responsive: true,
        serverSide: true,
        searching: false,
        processing: true,
        language: {
            processing: '<div style="text-align: center;"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-success"></i></div>'
        },
        
        ajax: {
            url: '{{ route('admins.index') }}',
            type: 'GET',
            dataType: 'JSON',
            accepts: 'JSON',
            dom: 'frtip',
            data: function(d) {
                d.filter_name = $('input[name=filter_name]').val();
                d.filter_email = $('input[name=filter_email]').val();
                d.filter_status = $('select[name=filter_status]').val();
                d.page = (d.start / d.length) + 1;
            },
            beforeSend: function() {},
            dataSrc: function(response) {
                console.log(response);
            return response.data;
            }
        },
        columns: [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email',
            },
        
            {
                data: 'active_status',
                name: 'active_status'
            },
            {
                data: 'actions',
                name: 'actions'
            },
        ]
    });

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#createNewAdmin').click(function() {
            $('#saveBtn').val("create-fundraiser");
            $('#fundraiser_id').val('');
            $('#nameError').html('');
            $('#emailError').html('');
            $('#passwordError').html('');
            $('#fundraiser_password').show();
            $('#FundraiserForm').trigger("reset");
            $('#modelHeading').html("Create New Admin");
            $('#ajaxModel').modal('show');
        });
    
        $('body').on('click', '.edituser', function() {
            
            var user_id = $(this).data('id');
            $.get("{{ route('admins.index') }}" + '/' + user_id + '/edit', function(data) {
                $('#modelHeading').html("Edit Admins");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#fundraiser_password').hide();
                $('#nameError').html('');
                $('#emailError').html('');
                $('#user_id').val(data.user.id);
                $('#name').val(data.user.name);
                $('#email').val(data.user.email);
                $('#status').prop('checked', data.user.status == 1);
            })

        });

        $('body').on('click', '.deleteuser', function() {

            var user_id = $(this).data("id");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "Videos uploaded by this admin will also be deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No , Cancel it",
                reverseButtons: true ,
                allowOutsideClick: false, 
                showLoaderOnConfirm: true, 
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admins.store') }}" + '/' + user_id,
                        success: function(data) {
                            table.draw();
                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancellation if needed
                }
            });
        });
        $('body').on('click', '.blockStatus', function() {

            var user_id = $(this).data("id");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You really want to block!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Block it!",
                cancelButtonText: "No , Cancel it",
                reverseButtons: true ,
                allowOutsideClick: false, 
                showLoaderOnConfirm: true, 
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('admins/block') }}/" + user_id,
                        success: function(data) {
                            table.draw();
                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancellation if needed
                }
            });
        });
        $('body').on('click', '.UnblockStatus', function() {

            var user_id = $(this).data("id");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You really want to un block!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Un Block it!",
                cancelButtonText: "No , Cancel it",
                reverseButtons: true ,
                allowOutsideClick: false, 
                showLoaderOnConfirm: true, 
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('admins/unblock') }}/" + user_id,
                        success: function(data) {
                            table.draw();
                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancellation if needed
                }
            });
        });

    });

    $('body').on('click', '#closeModalBtn', function() {
        $('#ajaxModel').modal('hide');
    });

    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('FundraiserForm');
        var saveBtn = document.getElementById('saveBtn');

        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Check if the form is valid
            if (validateForm()) {

                $.ajax({
                    data: $('#FundraiserForm').serialize(),
                    url: "{{ route('admins.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#FundraiserForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: data.success
                        });
                        table.draw();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON.errors.email[0];
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                });
            }
        });


       
        function validateForm() {
            var nameInput = document.getElementById('name');
            var nameError = document.getElementById('nameError');

            var emailInput = document.getElementById('email');
            var emailError = document.getElementById('emailError');

            var passwordInput = document.getElementById('password');
            var passwordError = document.getElementById('passwordError');

        
            // Reset error messages
            nameError.textContent = '';
            emailError.textContent = '';
            
            

            // Validate name
            if (nameInput.value.trim() === '') {
                nameError.textContent = 'Please enter a name';
                return false;
            } else if (nameInput.value.length < 3) {
                nameError.textContent = 'Name must be at least 3 characters long';
                return false;
            }

            // Validate email
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() === '') {
                emailError.textContent = 'Please enter an email address';
                return false;
            } else if (!emailRegex.test(emailInput.value)) {
                emailError.textContent = 'Please enter a valid email address';
                return false;
            }

            // Validate password
            var fundraiserPasswordField = document.getElementById('fundraiser_password');
            if (getComputedStyle(fundraiserPasswordField).display !== 'none') {
                passwordError.textContent = '';
                if (passwordInput.value.trim() === '') {
                    passwordError.textContent = 'Please enter password';
                    return false;
                } else if (passwordInput.value.length < 6) {
                    passwordError.textContent = 'Password must be at least 6 characters long';
                    return false;
                }
            }
           
           
            return true;
        }
    });
</script>
@endsection