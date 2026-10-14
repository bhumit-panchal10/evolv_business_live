@extends('layouts.app')
@section('title', 'City Group List')
@section('content')

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



                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Group</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('serviceprovider.citygroupstore') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4" style="align-items: end;">
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="city_id"><span style="color:red;">*</span> City
                                                        Name</label>
                                                    <select class="form-control" name="city_id" required>
                                                        <option value="" disabled selected>Select City Name</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}">{{ $city->city_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mt-3">
                                                    <span style="color:red;">*</span>Group Name
                                                    <input type="text" class="form-control" name="group_name"
                                                        id="group_name" onblur="chkname();" placeholder="Enter Group Name"
                                                        maxlength="100" autocomplete="off" required>
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
                                <h5 class="card-title mb-0">Group List</h5>
                            </div>
                            <div class="card-body">
                                <?php //echo date('ymd');
                                ?>
                                @if($Count > 0 )
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No</th>
                                            <th scope="col">Group Name</th>
                                            <th scope="col">City Name</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-center">{{ $data->group_name }}</td>
                                                <td class="text-center">
                                                    {{ optional($cities->firstWhere('id', $data->city_id))->city_name }}
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
                                    {{ $datas->links() }}
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
                                                    <td class="text-center">{{ $data->city_name }}</td>
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
                                <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form method="POST" onsubmit="return EditvalidateFile()"
                                action="{{ route('serviceprovider.citygroupupdate') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="getid">

                                <div class="modal-body">

                                    <div>
                                        <label for="city_id"><span style="color:red;">*</span> City Name</label>
                                        <select class="form-control" name="city_id" id="city_id" required>
                                            <option value="" disabled selected>Select City Name</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 pt-3">
                                        <span style="color:red;">*</span>Group Name
                                        <input type="text" class="form-control" onblur="editchkname();"
                                            name="group_name" id="Editname" maxlength="100" autocomplete="off" "
                                                required>
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
                                            action="{{ route('serviceprovider.citygroupdelete') }}">
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
                 var url = "{{ route('serviceprovider.citygroupedit', ':id') }}";
                 url = url.replace(":id", id);
                 if (id) {
                     $.ajax({
                         url: url,
                         type: 'GET',
                         data: {
                             id: id
                         },
                         success: function(data) {
                             // console.log(data);
                             var obj = JSON.parse(data);
                             // alert(obj);
                             $("#Editname").val(obj.group_name);
                             $('#getid').val(obj.id);
                             $('#city_id').val(obj.city_id);
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

        <script>
            function chkname() {
                var name = $('#group_name').val();
                var url = "{{ route('serviceprovider.citygroupcheckserviceprovider') }}";
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

                            alert('CityGroup Name Already Exist');
                            $('#group_name').val('');
                            $('#group_name').focus();
                            return false;

                        }
                    }
                });
            }
        </script>
        <script>
            function editchkname() {
                var name = $('#Editname').val();
                var id = $('#getid').val();
                var url = "{{ route('serviceprovider.citygroupeditcheckserviceprovider') }}";

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        name: name,
                        id: id
                    },
                    success: function(data) {
                        console.log(data);
                        if (data == 1) {
                            alert('CityGroup Name Already Exists');
                            $('#Editname').val('');
                            $('#Editname').focus();
                            return false;
                        }
                    }
                });
            }
        </script>

<script>
    function cancelForm() {
        window.location.reload(); 
    }
</script>

@endsection
