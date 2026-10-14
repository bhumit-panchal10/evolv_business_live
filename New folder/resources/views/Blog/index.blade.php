@extends('layouts.app')
@section('title', 'Blog')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">   
                {{-- Alert Messages --}}
                @include('common.alert')
              <?php  $user = Auth::user(); ?>
            
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="display: flex;justify-content: space-between;">
                            <h5 class="card-title mb-0">Blog List</h5>
                            <a class="btn btn-success" href="{{ route('Blog.create') }}">Add Blog</a>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 mt-3">
                                <div class="card mb-3">
                                    <div class="card-body pt-0">
                                        <div class="tab-content">
                                            <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                                aria-labelledby="tab-dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540"
                                                id="dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540">
                                                <div id="tableExample" data-list='{"valueNames":["name","email","age"]}'>
                                                    <div class="table-responsive scrollbar">
                                                        <table class="table table-bordered table-striped fs--1 mb-0">
                                                            <thead class="bg-200 text-900">
                                                                <tr>
                                                                    <th width="2%" data-sort="Title">
                                                                        Sr No</th>
                                                                        <th width="3%" data-sort="Title">User
                                                                            Name</th>
                                                                    <th width="5%" data-sort="Title">Blog
                                                                        Title</th>
                                                                    <th width="2%" data-sort="Photo">Blog
                                                                        Image</th>
                                                                    <!-- <th width="5%" data-sort="Title">Blog
                                                                        Description</th> -->
                                                                    <th width="1%" data-sort="Title">
                                                                        Status</th>
                                                                                                                
                                                                            @if ($user->role_id == 2)
                                                                                <th width="3%" data-sort="Title">rejectedcomments</th>                                                                        
                                                                            @endif


                                                                    <th width="2%" data-sort="Action">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="list">
                                                                <?php $i = 1; ?>
                                                                @foreach ($Data as $data)
                                                                    <tr>
                                                                        <td>{{ $i + $Data->perPage() * ($Data->currentPage() - 1) }}
                                                                        </td>
                                                                        <td class="text-center">{{ $data->first_name }}</td>
                                                                        <td class="text-center">{{ $data->blogTitle }}</td>
                                                                        <td class="text-center">
                                                                            <img src="{{ asset('Blog') . '/' . $data->blogImage }}"
                                                                                style="width: 50px;height: 50px;">
                                                                        </td>
                                                                        <!-- <td>{{ $data->blogDescription }}</td> -->
                                                                        {{-- admin  --}}
                                                                        @if ($user->role_id == 1)
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-link"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#statusModal"
                                                                                    onclick="getEditData(<?= $data->blogsid ?>)">
                                                                                    <!-- {{ $data->blogstatus == 0 ? 'Pending' : 'Approved' }} -->
                                                                                    {{ $data->blogstatus == 0 ? 'Pending' : ($data->blogstatus == 1 ? 'Approved' : 'Rejected') }}
                                                                                </button>

                                                                            </td>
                                                                        @else
                                                                            <td class="text-center">
                                                                                <!-- {{ $data->blogstatus == 0 ? 'Pending' : 'Approved' }}                                         -->
                                                                 {{ $data->blogstatus == 0 ? 'Pending' : ($data->blogstatus == 1 ? 'Approved' : 'Rejected') }}
                                                                            </td>
                                                                            <td>{{ $data->rejectedcomments }}</td>
                                                                        @endif


                                                                        <td class="d-flex gap-2 justify-content-center">
                                                                           
                                                                            <a href="{{ route('Blog.edit', $data->blogsid) }}"
                                                                                class="" title="Edit">
                                                                                <span class="text-500 fas fa-edit"></span>
                                                                            </a>

                                                                            <a class="" href="#"
                                                                                data-bs-toggle="modal" title="Delete"
                                                                                data-bs-target="#deleteRecordModal"
                                                                                onclick="deleteData(<?= $data->blogsid ?>);">
                                                                                <i class="fa fa-trash"
                                                                                    aria-hidden="true"></i>
                                                                            </a>

                                                                            {{-- <form
                                                                                action="{{ route('Blog.delete', $data->blogsid) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Are you Sure You wanted to Delete?');"
                                                                                style="display: inline-block;">
                                                                                <input type="hidden" name="_method"
                                                                                    value="DELETE">
                                                                                <input type="hidden" name="_token"
                                                                                    value="{{ csrf_token() }}">
                                                                                <button type="submit"
                                                                                    class="btn btn-link p-0"><span
                                                                                        class="text-500 fas fa-trash-alt"></span></button>
                                                                            </form> --}}
                                                                        </td>
                                                                    </tr>
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="d-flex justify-content-center mt-3">
                                                    {{ $Data->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



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
                        <form id="user-delete-form" method="POST" action="{{ route('Blog.delete') }}">
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



    {{-- model rejectedcomments --}}

    <!-- Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Change Status
                        Comments</h5>
                    <button type="button" class="btn btn-light" onclick="$('#statusModal').modal('hide')">
                        Close
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add a form for changing status and adding rejected comments -->
                    <form action="{{ route('Blog.status') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="blogeid" value="">
                        <div class="form-group">
                            <label for="newStatus">Update Status:</label>
                            {{-- {{dd($data)}} --}}
                            @if (isset($data->blogstatus))
                              
                                <select class="form-control" name="newStatus" id="newStatus" onchange="toggleRejectedComments()">
                                    <option value="1" {{ $data->blogstatus == 1 ? 'selected' : '' }}>Approved</option>
                                    <option value="2" {{ $data->blogstatus == 2 ? 'selected' : '' }}>Rejected</option>
                                </select>

                            @else
                                <select class="form-control" name="newStatus">
                                    <option value="1">Approved</option>
                                    <option value="0">Pending</option>
                                </select>
                            @endif
                        </div>
                        <div class="form-group rejectedComments" style="display: {{ isset($data->blogstatus) && $data->blogstatus == 2 ? 'block' : 'none' }}">
                            <label for="rejectedComments">Rejected Comments:</label>
                            <textarea class="form-control" name="rejectedComments"></textarea>
                        </div><br>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- mode end rejectedcomments --}}



@endsection

@section('scripts')

    <script>
        $(window).on('load', function() {
            $('#description').ckeditor();
            $('#editdesc').ckeditor();
        });

        function getEditData(id) {
            var url = "";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        var obj = JSON.parse(data);
                        $("#EditCategoryID").val(obj.categoryId);
                        $("#EditblogTitle").val(obj.blogTitle);
                        $("#Edithead").val(obj.head);
                        $("#EditmetaTitle").val(obj.metaTitle);
                        $("#EditmetaKeyword").val(obj.metaKeyword);
                        $("#EditmetaDescription").val(obj.metaDescription);
                        CKEDITOR.instances['editdesc'].setData(obj.blogDescription);
                        $('#hiddenPhoto').val(obj.blogImage);
                        var html = "";
                        if (obj.blogImage) {
                            html = '<img src="/Blog/' + obj.blogImage +
                                '" id="hiddenPhoto" width="50px" height = "50px" > ';
                        }
                        $('#PHOTOID').html(html);
                        $('#getid').val(id);
                    }
                });
            }
        }
    </script>

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
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
        function getEditData(id) {
            var name = $('#blogeid').val(id);
        }
    </script>


    <script>
        function deleteData(id) {
            //alert(id);
            $("#deleteid").val(id);
        }
    </script>


<script>
    function toggleRejectedComments() {
        var statusSelect = document.getElementById('newStatus');
        var rejectedComments = document.querySelector('.form-group.rejectedComments');

        if (statusSelect.value == 2) {
            rejectedComments.style.display = 'block';
        } else {
            rejectedComments.style.display = 'none';
        }
    }
</script>



@endsection
