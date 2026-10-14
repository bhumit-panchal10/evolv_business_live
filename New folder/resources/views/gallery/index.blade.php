
@extends('layouts.app')
@section('title', 'Gallery List')
@section('content')

    <div class="main-content">
           <div class="page-content">
                <div class="container-fluid">
                  
                    {{-- Alert Messages --}}
                    @include('common.alert')
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-end">
                                        <div class="col-auto align-self-center">
                                            <h5 class="card-title mb-0">Add Gallery</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light">
                                    <div class="tab-content">
                                        <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                            aria-labelledby="tab-dom-160a4566-7e94-45a2-bf04-b36ef49d954f"
                                            id="dom-160a4566-7e94-45a2-bf04-b36ef49d954f">
                                            <form onsubmit="return validateFile()" method="POST" id="myForm"
                                                action="{{ route('gallery.create') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <span style="color:red;">*</span>Title</label>
                                                    <input class="form-control" id="basic-form-name" name="name" type="text"
                                                        placeholder="Enter Title" value="{{ old('name') }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <span style="color:red;">*</span>Photo</label>
                                                    <input class="form-control" type="file" name="photo" id="photovalidate"
                                                        value="{{ old('photo') }}" required>
                                                    <div id="viewimg">

                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button type="submit" class="btn btn-success btn-user float-right">Submit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-user float-right" onclick="cancelForm()">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 mt-3">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-end">
                                        <div class="col-auto align-self-center">
                                            <h5 class="card-title mb-0" data-anchor="data-anchor">Gallery List
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                            aria-labelledby="tab-dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540"
                                            id="dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540">
                                            <div id="tableExample" data-list='{"valueNames":["name","email","age"]}'>
                                                <div class="table-responsive scrollbar">
                                                    <table class="table table-bordered table-striped fs--1 mb-0">
                                                        <thead class="bg-200 text-900">
                                                            <tr>
                                                                <th width="2%" data-sort="Title">Sr No</th>
                                                                <th width="5%" data-sort="Title">Title</th>
                                                                <th width="1%" data-sort="Photo">Photo</th>
                                                                <th width="1%" data-sort="Action">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                            <?php $i = 1; ?>
                                                            @foreach ($Gallery as $gallery)
                                                                <tr>
                                                                    <td class="text-center"> {{ $i + $Gallery->perPage() * ($Gallery->currentPage() - 1) }}</td>
                                                                    <td class="text-center">{{ $gallery->name }}</td>
                                                                    <td class="text-center"><img src="{{ asset('Gallery') . '/' . $gallery->photo }}"
                                                                            style="width: 50px;height: 50px;">
                                                                    </td>
                                                                    <td class="d-flex gap-2 justify-content-center">
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#EditModal"
                                                                            onclick="getEditData(<?= $gallery->gallery_id ?>)"
                                                                            class="" title="Edit">
                                                                            <span class="text-500 fas fa-edit"></span>
                                                                        </a>
                                                                        <a class="" href="#"
                                                                            data-bs-toggle="modal" title="Delete"
                                                                            data-bs-target="#deleteRecordModal"
                                                                            onclick="deleteData(<?= $gallery->gallery_id ?>);">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        </a>

                                                                     

                                                                        <a href="{{ route('gallerydetail.index', $gallery->gallery_id)}}"
                                                                            class="" title="Add Album Photo">
                                                                            <span class="text-500 fas fa-plus"></span>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php $i++; ?>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="d-flex justify-content-center mt-3">
                                                {{ $Gallery->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog " style="background-color: white;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Album</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </button>
                                </div>
                                <form onsubmit="return EditvalidateFile()" method="post"
                                    action="{{ route('gallery.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="modal-body">

                                        <input type="hidden" name="gallery_id" id="gallery_id" value="">

                                        <div class="row">
                                            <div class="form-group">
                                                <span style="color:red;">*</span>Title</label>
                                                <input class="form-control" id="Editname" name="name" type="text"
                                                    placeholder="Enter Title" value="{{ old('name') }}" required>
                                            </div><br>
                                            <div class="form-group mt-2">
                                                <span style="color:red;">*</span>Photo</label>
                                                <input type="file" name="photo" class="form-control" id="Editphoto">
                                                <input type="hidden" name="hiddenPhoto" class="form-control" id="hiddenPhoto">
                                                <div id="PHOTOID">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-success">
                  
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    {{-- @endforeach --}}

     <!--Delete Modal Start -->
     <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                        </lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                            Yes,
                            Delete It!
                        </a>
                        <form id="user-delete-form" method="POST" action="{{ route('gallery.delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" id="deleteid" value="">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Delete modal End -->
@endsection

@section('scripts')
    <script>
        function getEditData(id) {
            //alert(id);
            var url = "{{ route('gallery.edit', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id,
                        id
                    },
                    success: function(data) {
                        //console.log(data);
                        var obj = JSON.parse(data);
                        $("#Editname").val(obj.name);
                        $('#hiddenPhoto').val(obj.photo);
                        var html = "";
                        if (obj.photo) {
                            html = '<img src="/Gallery/' + obj.photo +
                                '" id="hiddenPhoto" width="50px" height = "50px" > ';
                        }
                        $('#PHOTOID').html(html);
                        $('#gallery_id').val(id);
                    }
                });
            }
        }
    </script>

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png',
                'webp'
            ];
            var fileExtension = document.getElementById('photovalidate').value.split('.').pop().toLowerCase();
            var isValidFile = false;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }

            if (!isValidFile) {
                alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
            }

            return isValidFile;
        }
    </script>

    <script>
        function EditvalidateFile() {
            //alert('hello');
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
            var fileExtension = document.getElementById('Editphoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;
            var image = document.getElementById('Editphoto').value;
            for (var index in allowedExtension) {
                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (image != "") {
                if (!isValidFile) {
                    alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
                }
                return isValidFile;
            }
            return true;
        }
    </script>

    {{-- Add photo --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#photovalidate").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#viewimg').html(html);
        });
    </script>

    {{-- Edit photo --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#Editphoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#PHOTOID').html(html);
        });
    </script>
      <script>
        function deleteData(id) {
            // alert(id);
            $("#deleteid").val(id);
        }
    </script>

<script>
        function cancelForm() {
            window.location.reload(); 
        }
    </script>
@endsection
