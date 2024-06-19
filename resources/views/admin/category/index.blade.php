@extends('layouts.admin')
@section('title', 'Categories')
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
            <h4 class="mb-sm-0 font-size-18">Categories</h4>
            {{-- {{ $errors }}--}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Categories</li>
                </ol>
              
                <button type="button" class="btn btn-primary mt-2" href="javascript:void(0)" id="createNewCategory">
                    <i class="fa fa-plus"></i> Add New Category
                </button>
            </div>
        </div>
    </div>
</div>
<div class="card">
  
    <div class="card-body">
        
            <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="email">Seach By Name :</label>
                    <input type="text" name="filter_name" class="form-control" id="filter_name"  placeholder="Search by Name" />
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="dob">Search By Status : </label>
                    <select name="filter_status" class="filter_status form-control" id="exampleFormControlSelect1">
                        <option value="">Select Status</option>
                        <option value="1" >Active</option>
                        <option value="0" >InActive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
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
                            <th>Image</th>
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
                <form id="CategoryForm" name="CategoryForm" class="form-horizontal">
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input required type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                            <span id="nameError" class="error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="image" name="image" value="" accept="image/*">
                            <span id="imageError" class="error"></span>
                        </div>
                        <img class="mt-2" height="100px" id="category_image" src="" alt="">
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
                url: '{{ route('category.index') }}',
                type: 'GET',
                dataType: 'JSON',
                accepts: 'JSON',
                dom: 'frtip',
                data: function(d) {
                    d.filter_name = $('input[name=filter_name]').val();
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
                data: 'image',
                name: 'image',
            },
            {
                data: 'status',
                name: 'status'
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

        $('#createNewCategory').click(function() {
            $('#saveBtn').val("create-category");
            $('#category_id').val('');
            $('#nameError').html('');
            $('#imageError').html('');
            $('#category_image').attr('src', '');
            $('#CategoryForm').trigger("reset");
            $('#modelHeading').html("Create New Category");
            $('#ajaxModel').modal('show');
        });


        $('body').on('click', '.editCategory', function() {
            
            var category_id = $(this).data('id');
            $.get("{{ route('category.index') }}" + '/' + category_id + '/edit', function(data) {
                $('#modelHeading').html("Edit Category");
                $('#saveBtn').val("edit-category");
                $('#ajaxModel').modal('show');
                $('#nameError').html('');
                $('#imageError').html('');
                $('#category_id').val(data.category.id);
                $('#name').val(data.category.name);
                $('#category_image').attr('src', data.category.image);
                // $('#trending').prop('checked', data.category.trending == 1);
                $('#status').prop('checked', data.category.status == 1);
            })

        });

        $('body').on('click', '.deleteCategory', function() {

            var category_id = $(this).data("id");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No , Cancel it",
                reverseButtons: true ,
                allowOutsideClick: false, 
                showLoaderOnConfirm: true, 
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('category.store') }}" + '/' + category_id,
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
        var saveBtn = document.getElementById('saveBtn');

        saveBtn.addEventListener('click', function (e) {
            e.preventDefault();

            var formData = new FormData($('#CategoryForm')[0]);

            // Check if the form is valid
            if (validateForm()) {
                $.ajax({
                    data: formData,
                    url:  "{{ route('category.store') }}",
                    type: "POST",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $('#CategoryForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: data.success
                        });
                        table.draw();
                    },
                    error: function (xhr, status, error) {
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

            // Reset error messages
            nameError.textContent = '';

            // Validate name
            if (nameInput.value.trim() === '') {
                nameError.textContent = 'Please enter a name';
                return false;
            } else if (nameInput.value.length < 3) {
                nameError.textContent = 'Name must be at least 3 characters long';
                return false;
            }

            
           
            var imageInput = document.getElementById('image');
            var imageError = document.getElementById('imageError');
            imageError.textContent = '';
            if (imageInput.files.length > 0) {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                if (!allowedExtensions.exec(imageInput.value)) {
                    imageError.textContent = 'Please choose a valid image file (JPG, JPEG, PNG, GIF)';
                    return false;
                }
            }
           
            return true;
        }
    });
</script>
@endsection