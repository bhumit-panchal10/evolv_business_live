
@extends('layouts.app')
@section('title', 'Admin user List')
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
                                <h5 class="card-title mb-0">Add Admin User</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('Adminuser.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4" style="align-items: end;">
                                            <div class="col-lg-12">
                                                <div>
                                                    <span style="color:red;">*</span>Name
                                                    <input type="text" class="form-control" name="first_name" id="name"
                                                        placeholder="Enter Admin User Name" maxlength="100"
                                                        autocomplete="off" value="{{old('first_name')}}" required>    
                                                </div>
                                                <div>
                                                    <span style="color:red;">*</span>Email
                                                    <input type="text" class="form-control" name="email" id="email"
                                                        placeholder="Enter Email " maxlength="100"
                                                        autocomplete="off" value="{{old('email')}}" required>    
                                                </div>
                                                <div>
                                                    <span style="color:red;">*</span> Password
                                                    <input type="password" class="form-control" name="password" id="password"
                                                        placeholder="Enter Password" value="{{old('password')}}" required>
                                                </div>
                                                <div>
                                                    <span style="color:red;">*</span> Phone Number
                                                    <input type="number" class="form-control" name="phonenumber"
                                                        id="phonenumber" placeholder="Enter Phone Number" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;"value="{{old('phonenumber')}}" required>
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
                                <h5 class="card-title mb-0">Admin User List</h5>
                            </div>
                            <div class="card-body">
                                <?php //echo date('ymd');
                                ?>
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Action</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                     
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">{{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                <td class="text-center">{{ $data->first_name }}</td>
                                                <td class="text-center">{{ $data->email }}</td>
                                                <td class="text-center">{{ $data->mobile_number }}</td>
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

                                                        <a class="" href="{{ route('Userpermission.index',$data->id) }}" title="Permission">
                                                            <i class="fas fa-plus-square" aria-hidden="true"></i>
                                                        </a>

                                                    </div>
                                                </td>  
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!--Edit Modal Start-->
                <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Admin User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form method="POST" onsubmit="return EditvalidateFile()"
                                action="{{ route('Adminuser.update') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="getid" value="">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Name
                                        <input type="text" class="form-control" name="first_name"
                                            id="Editname" placeholder="Enter Category Name" maxlength="100" autocomplete="off"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Email
                                        <input type="text" class="form-control" name="email"
                                            id="Editemail" placeholder="Enter Email" maxlength="100" autocomplete="off"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Phone Number
                                        <input type="text" class="form-control" name="mobile_number"
                                            id="Editphonenumber" placeholder="Enter Phone Number" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" maxlength="100" autocomplete="off"
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
                                        action="{{ route('Adminuser.delete') }}">
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
            var url = "{{ route('Adminuser.edit', ':id') }}";
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
                        $("#Editname").val(obj.first_name);
                        $("#Editemail").val(obj.email);
                        $("#Editphonenumber").val(obj.mobile_number);
                        $('#getid').val(id);
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
<script>
        function cancelForm() {
            window.location.reload(); 
        }
    </script>

@endsection
