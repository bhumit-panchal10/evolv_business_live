
@extends('layouts.app')
@section('title', 'Video List')
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
                                            <h5 class="card-title mb-0">Add Video Gallery</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light">
                                    <div class="tab-content">
                                        <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                            aria-labelledby="tab-dom-160a4566-7e94-45a2-bf04-b36ef49d954f"
                                            id="dom-160a4566-7e94-45a2-bf04-b36ef49d954f">
                                            <form onsubmit="return validateFile()" method="POST" id="myForm"
                                                action="{{ route('videogallery.create') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <span style="color:red;">*</span>Title</label>
                                                    <input class="form-control" id="basic-form-name" name="name" type="text"
                                                        placeholder="Enter Title" value="{{ old('name') }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <span style="color:red;">*</span>Vide Url</label>
                                                    <input class="form-control" id="basic-form-name1" name="vidoeurl" type="text"
                                                        placeholder="Enter Vidoe Url" value="{{ old('vidoeurl') }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <span style="color:red;">*</span>Comments</label>
                                                    <input class="form-control" id="basic-form-name1" name="comments" type="text"
                                                        placeholder="Enter Comments" value="{{ old('comments') }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <span style="color:red;">*</span>Date
                                                    <input class="form-control" id="dateid" name="date" type="text" placeholder="Enter Date" value="{{ old('date') }}" required>
                                                </div>
                                                <!-- <div class="mb-3">
                                                    <span style="color:red;">*</span>Photo</label>
                                                    <input class="form-control" type="file" name="photo" id="photovalidate"
                                                        value="{{ old('photo') }}" required>
                                                    <div id="viewimg">
                                                    </div>
                                                </div> -->
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
                                            <h5 class="card-title mb-0" data-anchor="data-anchor">Video Gallery List
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
                                                                <th width="5%" data-sort="Photo">Video Url</th>
                                                                <th width="5%" data-sort="Photo">Comment</th>
                                                                <th width="5%" data-sort="Action">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                            <?php $i = 1; ?>
                                                            @foreach ($Gallery as $gallery)
                                                                <tr>
                                                                    <td class="title"> {{ $i + $Gallery->perPage() * ($Gallery->currentPage() - 1) }}</td>
                                                                    <td class="title">{{ $gallery->name }}</td>
                                                                    <td class="title">{{ $gallery->vidoeurl }}</td>
                                                                    <td class="title">{{ $gallery->comments }}</td>
                                                                    <!-- <td><img src="{{ asset('Gallery') . '/' . $gallery->photo }}"
                                                                            style="width: 50px;height: 50px;">
                                                                    </td> -->
                                                                    <td class="flex gap-2">
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#EditModal"
                                                                            onclick="getEditData(<?= $gallery->video_id ?>)"
                                                                            class="" title="Edit">
                                                                            <span class="text-500 fas fa-edit"></span>
                                                                        </a>
                                                                        <a class="" href="#"
                                                                            data-bs-toggle="modal" title="Delete"
                                                                            data-bs-target="#deleteRecordModal"
                                                                            onclick="deleteData(<?= $gallery->video_id ?>);">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        </a>

                                                                        <!-- <form action="{{ route('videogallery.delete', $gallery->video_id) }}"
                                                                            method="POST" title="Delete"
                                                                            onsubmit="return confirm('Are you Sure You wanted to Delete?');"
                                                                            style="display: inline-block;">
                                                                            <input type="hidden" name="_method" value="DELETE">
                                                                            <input type="hidden" name="_token"
                                                                                value="{{ csrf_token() }}">
                                                                            <button type="submit" class="btn btn-link p-0"><span
                                                                                    class="text-500 fas fa-trash-alt"></span></button>
                                                                        </form> -->
                                                                    </td>
                                                                </tr>
                                                                <?php $i++; ?>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="d-flex justify-content-center mt-3">
                                          
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
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Video</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </button>
                                </div>
                                <form onsubmit="return EditvalidateFile()" method="post"
                                    action="{{ route('videogallery.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="modal-body">

                                        <input type="hidden" name="video_id" id="video_id" value="">

                                        <div class="row">
                                            <div class="form-group">
                                                <span style="color:red;">*</span>Title</label>
                                                <input class="form-control" id="Editname" name="name" type="text"
                                                    placeholder="Enter Title" value="{{ old('name') }}" required>
                                            </div><br>
                                            <div class="form-group">
                                                <span style="color:red;">*</span>Video Url</label>
                                                <input class="form-control" id="Editvideourl" name="vidoeurl" type="text"
                                                    placeholder="Enter vidoe Url" value="{{ old('vidoeurl') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <span style="color:red;">*</span>Comments</label>
                                                <input class="form-control" id="Editcomment" name="comments" type="text"
                                                    placeholder="Enter Comments" value="{{ old('comments') }}" required>
                                            </div>
                                            <div class="form-group">
                                                    <span style="color:red;">*</span>Date
                                                    <input class="form-control" id="editdateid" name="date" type="text" placeholder="Enter Date" value="{{ old('date') }}" required>
                                            </div>
                                            <!-- <div class="form-group mt-2">
                                                <span style="color:red;">*</span>Photo</label>
                                                <input type="file" name="photo" class="form-control" id="Editphoto">
                                                <input type="hidden" name="hiddenPhoto" class="form-control" id="hiddenPhoto">
                                                <div id="PHOTOID">
                                                </div>
                                            </div> -->
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
                        <form id="user-delete-form" method="POST" action="{{ route('videogallery.delete') }}">
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
            var url = "{{ route('videogallery.edit', ':id') }}";
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
                        $("#Editvideourl").val(obj.vidoeurl);
                        $("#Editcomment").val(obj.comments);
                        $("#editdateid").val(obj.date);
                        $('#video_id').val(id);
                        // $('#hiddenPhoto').val(obj.photo);
                        // var html = "";
                        // if (obj.photo) {
                        //     html = '<img src="/Gallery/' + obj.photo +
                        //         '" id="hiddenPhoto" width="50px" height = "50px" > ';
                        // }
                        // $('#PHOTOID').html(html);
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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    
    <script>
    $(function() {
        $("#dateid").datepicker({
            dateFormat: "yy-mm-dd",
            //minDate: 0
        });      
    });
</script>
<script>
    $(function() {
        $("#editdateid").datepicker({
            dateFormat: "yy-mm-dd",
            //minDate: 0
        });      
    });
</script>
@endsection
