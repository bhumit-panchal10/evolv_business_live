@extends('layouts.app')
@section('title', 'Categoy Name List')
@section('content')

<style>
    
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="mb-5" style="color:red">{{ $error }}</li>
                    @endforeach
                @endif

                {{-- Alert Messages --}}
                @include('common.alert')
            <!-- search field new code start -->
            <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                            <form method="post" id="form" action="{{ route('categories.index') }}">
                                    @csrf
                                <div class="row align-items-center">
                                      
                                        <div class="col-md-3 mb-2">
                                            <div class="d-flex align-items-center">
                                            <select class="form-select select2" id="category_id" name="category_id" data-choices name="name">
                                                    <option value="">Select Category</option>
                                                    @foreach ($category as $categori)
                                                        <option value="{{ $categori->id }}" {{isset($categorysearch) && $categori->id == $categorysearch ? 'selected' : '' }}>{{ $categori->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                             
                                        <div class="col-md-3 mb-2">
                                            <div>
                                                <input type="submit" id="search" class="btn btn-success" name="search" title="Search" value="Search">
                                                <button type="button" id="cancel_search" class="btn btn-success">Cancel</button>
                                            </div>
                                        </div>
                                                                                
                                        <!-- <div class="col-md-3 mb-2 text-end">
                                                <a href="" class="btn btn-success">Add Member</a>
                                            </div> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

            <!-- search field new code End -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                        <div class="card-header">
                                <h5 class="card-title mb-0">Add Category Name</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('categories.store') }}" method="post"
                                    enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4" style="align-items: end;">
                                            <div class="col-lg-12">
                                                <div>
                                                    <span style="color:red;">*</span> Category Name
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        onblur="chkname();" placeholder="Enter Category Name" maxlength="100"
                                                        autocomplete="off" required>   
                                                </div>
                                                <div class="mb-3">
                                                    <span style="color:red;">*</span>Photo</label>
                                                    <input class="form-control" type="file" name="photo" id="photovalidate"
                                                        value="{{ old('photo') }}" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <button type="submit" class="btn btn-success btn-user float-right">Submit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-user float-right" onclick="cancelForm()">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Category List</h5>
                            </div>
                            <div class="card-body">
                                <?php //echo date('ymd');
                                ?>
                                @if($Count > 0 )
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No</th>
                                            <th scope="col">Category Name</th>
                                            <th scope="col">Photo</th>

                                                <th scope="col">Action</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">{{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                <td class="text-center">{{ $data->name }}</td>
                                                <td><img src="{{ asset('category') . '/' . $data->photo }}"
                                                                            style="width: 40px;height: 40px;">
                                                </td>
                                                  <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a class="mx-1" title="Edit" href="#"
                                                            onclick="getEditData(<?= $data->id ?>)" data-bs-toggle="modal"
                                                            data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>

                                                        <a class="" href="#" data-bs-toggle="modal"
                                                            title="Delete" data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $data->id ?>);">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>

                                                    </div>
                                                </td>  
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                {{ $datas->appends(request()->except('page'))->links() }}
                        
                                </div>
                                @else 
                                <div class="row">
                                <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                        <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                            <h1 class="font-white text-center"> No Data Found ! </h1>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
<!-- 
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">City Name List</h5>
                            </div>
                            <div class="card-body">
                                <?php //echo date('ymd');
                                ?>
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col"> Name</th>
                                            {{--  <th scope="col">Action</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-center">{{ $data->name }}</td>
                                                {{--  <td>
                                                    <div class="d-flex gap-2">
                                                        <a class="mx-1" title="Edit" href="#"
                                                            onclick="getEditData(<?= $data->id ?>)" data-bs-toggle="modal"
                                                            data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>

                                                        <a class="" href="#" data-bs-toggle="modal"
                                                            title="Delete" data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $data->id ?>);">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>

                                                    </div>
                                                </td>  --}}
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $datas->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!--Edit Modal Start-->
                <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Edit category Name</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form method="POST" onsubmit="return EditvalidateFile()"
                                action="{{ route('categories.update') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="getid" value="">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Category Name
                                        <input type="text" class="form-control" onblur="editchkname();" name="name"
                                            id="Editname" placeholder="Enter Category Name" maxlength="100" autocomplete="off"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                                    <span style="color:red;">*</span>Photo</label>
                                                    <input type="file" name="photo" class="form-control" id="Editphoto">
                                                    <input type="hidden" name="hiddenPhoto" class="form-control" id="hiddenPhoto">
                                                     <div id="PHOTOID">
                                                    </div>
                                                </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-success" id="add-btn">Update</button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Edit Modal End -->

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
                                    <button type="button" class="btn w-sm btn-light"
                                        data-bs-dismiss="modal">Close</button>
                                    <a class="btn btn-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                        Yes,
                                        Delete It!
                                    </a>
                                    <form id="user-delete-form" method="POST"
                                        action="{{ route('categories.delete') }}">
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

            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        function getEditData(id) {
            //alert(id);
            var url = "{{ route('categories.edit', ':id') }}";
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
                        $('#getid').val(id);
                        $('#hiddenPhoto').val(obj.photo);
                        var html = "";
                        if (obj.photo) {
                            html = '<img src="/category/' + obj.photo +
                                '" id="hiddenPhoto" width="50px" height = "50px" > ';
                        }
                        $('#PHOTOID').html(html);
                    }
                });
            }
        }
    </script>

    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>

    <!-- <script>
        function chkname() {
            var name = $('#name').val();
            var url = "{{ route('categories.checkserviceprovider') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    name,
                    name
                },
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (data == 1) {

                        alert('category Name Already Exist');

                        $('#name').val('');
                        $('#name').focus();
                        return false;

                    }
                }
            });
        }
    </script> -->
    <script>
        function editchkname() {
            var name = $('#Editname').val();
            var url = "{{ route('categories.editcheckserviceprovider') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    name,
                    name
                },
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (data == 1) {

                        alert('category Name Already Exist');
                        $('#Editname').val('');
                        $('#Editname').focus();
                        return false;

                    }
                }
            });
        }
    </script>


<!-- search new code -->
<script>
    $(document).ready(function(){
        // Add click event listener to the cancel button
        $('#cancel_search').click(function(){
            // Reset the value of the category_id select element to empty
            $('#category_id').val('');
            // Submit the form to fetch all data
            $('#form').submit();
        });
    });
</script>

<!-- search new code end  -->

<script>
    function cancelForm() {
        window.location.reload(); 
    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>
@endsection
