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
                </ol>
              
                <a type="button" class="btn btn-primary mt-2" href="{{ route('videos.create') }}">
                    <i class="fa fa-plus"></i> Add New Video
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card">
  
    <div class="card-body">
        
            <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Seach By Name :</label>
                    <input type="text" name="filter_name" class="form-control" id="filter_name"  placeholder="Search by Name" />
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="dob">Search By Status : </label>
                    <select name="filter_status" class="filter_status form-control" id="exampleFormControlSelect1">
                        <option value="">Select Status</option>
                        <option value="1" >Active</option>
                        <option value="0" >InActive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
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
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Resolution</th>
                            <th>Category</th>
                            <th>Added By</th>
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

<!-- Detail view  -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Video Details</h5>
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                        <label for="">Title</label>
                        <div class="input-group">
                            <span id="title"></span>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                        <label for="">Slug</label>
                        <div class="input-group">
                            <span></span><span id="slug"></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                        <label for="">Stock</label>
                        <div class="input-group">
                            <span></span><span id="stock"></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                        <label for="resolution">Resolution</label>
                        <div class="input-group">
                            <span></span><span id="resolution"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group col-sm-12 col-md-12 col-xl-12 col-lg-12 mb-2">
                        <label for="">Category</label>
                        <div class="input-group">
                            <span></span><span id="category"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                        <label for="">Sku</label>
                        <div class="input-group">
                            <span></span><span id="sku"></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                        <label for="">Size</label>
                        <div class="input-group">
                            <span></span><span id="size"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group mb-2">
                        <label for="">Variations</label>
                        <div class="">
                            <ul id="variations-list">
                                <!-- video variations will be added here dynamically -->
                            </ul>
                        </div>
                    </div>
                    <hr>                 
                    <div class="form-group col-sm-12 col-md-12 col-xl-12 col-lg-12 mb-2">
                        <label class="mt-2 mb-2">Images</label>
                        <div class="row">
                            <div class="col-12" style="overflow-x: auto;">
                                <div class="d-flex">
                                    <img class="mr-3 p-2" height="110" width="110" id="mainImage" src="" alt="Main Image">
                                    <div id="allImages" class="d-flex flex-wrap align-items-center"></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <hr>
                    <div class="form-group col-12 mb-2">
                        <label for="">Description</label>
                        <div class="">
                            <p id="description"></p>
                        </div>
                        <span id="editorValidate" class="text-danger"></span>
                    </div>
                    <hr>
                    <div class="form-group col-sm-6 col-md-6 col-xl-6 col-lg-6 mb-2">
                        <label for="">Status</label>
                        <div class="input-group">
                            <span></span><span id="prod_status"></span>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    
    var table = $('#datatable').DataTable({

        responsive: true,
        serverSide: true,
        searching: false,
        processing: true,
        language: {
            processing: '<div style="text-align: center;"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-success"></i></div>'
        },
        ajax: {
            url: '{{ route('videos.index') }}',
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
                data: 'title',
                name: 'title'
            },
            {
                data: 'image',
                name: 'image',
            },
            {
                data: 'resolution',
                name: 'resolution',
            },
            {
                data: 'category',
                name: 'category',
            },
            {
                data: 'added_by',
                name: 'added_by',
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
    $('.search_btn').on('click', function() {
        table.draw();
    });


    $(document).ready(function() {
        $('#datatable').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const rowId = $(this).data('row-id');

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
                reverseButtons: true,
                allowOutsideClick: false, 
                showLoaderOnConfirm: true, 
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancellation if needed
                }
            });
        });

    $('body').on('click', '.detailsBtn', function() {
        var video_id = $(this).data('id');
        $('#title').text('');
        $('#description').text('');
        $('#resolution').text('');
        $('#price').text('');
        $('#category').empty();
        $('#sku').text('');
        $('#size').text('');
        $('#slug').text('');
        $('#stock').text('');
        $('#prod_status').text('');
        $('#mainImage').attr('src', '');
        var allImages = $('#allImages');
        allImages.empty();
        var variationsList = $('#variations-list');
        variationsList.empty();
        $.get("".replace('__video_id__', video_id), function(data) {
            $('#title').text(data.title);
            $('#description').text($('<div/>').html(data.description).text());
            $('#price').text(data.price);
            
            data.video_categories.forEach(function(videoCategory) {
                $('#category').append('<span class="badge badge-pill badge-soft-primary font-size-14">' + videoCategory.category.name + '</span>');
            });
           
            $('#sku').text(data.sku);
            $('#size').text(data.size);
            $('#slug').text(data.slug);
            $('#stock').text(data.stock);
            if (data.status == 1) {
                $('#prod_status').text('Active');
            } else {
                $('#prod_status').text('In Active');
            }
            $('#mainImage').attr('src', data.image);
            if(data.video_images.length > 0) {
                data.video_images.forEach(function (image) {
                    var imageItem = '<img class="mr-3 p-2" height="110" width="110" src="' + image.image + '" alt="video Image">';
                    allImages.append(imageItem);
                });
            }
            
            if (data.video_variations.length > 0) {
                data.video_variations.forEach(function (variation) {
                    var variationItem = '<li>' + variation.name + ': ' + variation.price + '</li>';
                    variationsList.append(variationItem);
                });
            } else {
                variationsList.append('<label>This video has no variations.</label>');
            }
            $('#detailModal').modal('show');
        });
    });

    });
</script>
@endsection