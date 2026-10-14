
@extends('layouts.app')
@section('title', 'Meeting Member list ')
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
              
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Meeting Member list
                                    </h5>
                                </div>
                            
                            </div>
                            <!-- <h5 class="card-title mb-0">Products Service List</h5> -->
                        </div>
                        <div class="card-body">
                            <?php //echo date('ymd');
                            ?>
                            
                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                            @if($count > 0)
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Member Name</th>
                                        <th scope="col">Meeting title</th>
                                        <th scope="col">Meeting start date</th>
                                        <th scope="col">Meeting End date</th> 
                                        <th scope="col">Comment</th> 
                                       
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datas as $data)
                                        <tr>

                                            <td class="text-center">
                                                {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                          
                                            <td class="text-center">{{ $data->Contact_person }}</td>
                                            <td class="text-center">{{ $data->Meeting_title }}</td>
                                            <td class="text-center">{{$data->start_date}}</td>
                                            <td class="text-center">{{$data->End_date}}</td>
                                            <td class="text-center" style="max-width:250px; white-space:normal; word-wrap:break-word; word-break:break-word;" title="{{ $data->comment }}">
                                                {{ \Illuminate\Support\Str::limit($data->comment, 100, '...') ?? 'No Comment' }}
                                            </td>

                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                </tbody>
                                @else
                                <div class="row">
                                                <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                                    <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundgreen">
                                                        <h1 class="font-white text-center">No Data Found ! </h1>
                                                    </div>
                                                </div>
                                            </div>
                                  
                                @endif
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $datas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!--Edit Modal Start-->

            {{-- <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form method="POST" onsubmit="return EditvalidateFile()"
                            action="{{ route('MemberProducts.update') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="getid">
                            <input type="hidden" name="member_id" id="memberid">


                            <div class="modal-body">

                                <div class="row gy-3 mb-3">
                                    <div class="col-lg-12 col-md-6">
                                        <span style="color:red;">*</span>Product Name
                                        <input type="text" class="form-control" name="product_name"
                                            id="editproductname" placeholder="Enter Product Name" maxlength="100"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="col-lg-12 col-md-6">
                                        <span style="color:red;">*</span> Photo
                                        <input type="file" class="form-control" name="photo" id="editphoto"
                                            placeholder="Enter Image" required>
                                        <p class="help-block">Please upload a photo for your profile.</p>
                                    </div>
                                </div>



                                <div class="row gy-3" style="align-items: end;">

                                    <!-- <div class="col-lg-12 col-md-6">
                                        <label for="description">
                                            <span style="color:red;">*</span>Description
                                        </label>
                                        <input type="text" class="form-control" name="description"
                                            id="editdescription" placeholder="Enter Description" maxlength="100"
                                            autocomplete="off" required>
                                    </div> -->


                                    <!-- <div class="col-lg-12 col-md-6">
                                        <span style="color:red;">*</span> Price
                                        <input type="number" class="form-control" name="price" id="editprice"
                                            placeholder="Enter price" >
                                    </div> -->
                                    <!-- new 27-02-2024 -->
                                    <div class="col-lg-12 col-md-6">
                                        <span style="color:red;">*</span> Price Type
                                        <select class="form-control" name="edit_price_type" id="edit_price_type" required>
                                            <option value="fixed">Fixed</option>
                                            <option value="ranged">Ranged</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-md-6" id="edit_fixed_price_input" style="display: none;">
                                        <span style="color:red;">*</span> Price
                                        <input type="number" class="form-control" name="edit_fixed_price" id="edit_fixed_price" placeholder="Enter price">
                                    </div>

                                    <div class="col-lg-12 col-md-6" id="edit_ranged_price_input" style="display: none;">
                                        <span style="color:red;">*</span> Price Range
                                        <div class="row gy-3">
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" name="edit_min_price" id="edit_min_price" placeholder="Min price">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" name="edit_max_price" id="edit_max_price" placeholder="Max price">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- new -->

                                    <div class="col-lg-12 col-md-6">
                                    <label for="description">
                                        <span style="color:red;">*</span>Description
                                    </label>
                                    <textarea class="form-control" name="description" id="editdescription" placeholder="Enter Description" rows="4" maxlength="500" autocomplete="off" required></textarea>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-success" id="add-btn">Update</button>
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            <!--Edit Modal End -->      

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
                        <form id="user-delete-form" method="POST"
                            action="{{ route('MemberProducts.delete') }}">
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
        var url = "{{ route('MemberProducts.productedit', ':id') }}";
        url = url.replace(":id", id);
        
        if (id) {
            $.ajax({
                url: url,
                type: 'GET',
                data: { id: id },
                success: function(data) {
                    var obj = JSON.parse(data);
                    
                    $("#editproductname").val(obj.product_name);
                    $("#editdescription").val(obj.description);
                    $('#getid').val(obj.memberservices_id);
                    $('#memberid').val(obj.member_id);
                    $("#edit_price_type").val(obj.price_type);
                    if (obj.price_type === 'fixed') {
                        $("#edit_fixed_price_input").show();
                        $("#edit_ranged_price_input").hide();
                        $("#edit_fixed_price").val(obj.price);
                    } else if (obj.price_type === 'ranged') {
                        $("#edit_fixed_price_input").hide();
                        $("#edit_ranged_price_input").show();
                        $("#edit_min_price").val(obj.min_price);
                        $("#edit_max_price").val(obj.max_price);
                    }
                }
            });
        }
    }
    $("#edit_price_type").on("change", function() {
        var selectedValue = $(this).val();
        if (selectedValue === 'fixed') {
            $("#edit_fixed_price_input").show();
            $("#edit_ranged_price_input").hide();
        } else if (selectedValue === 'ranged') {
            $("#edit_fixed_price_input").hide();
            $("#edit_ranged_price_input").show();
        }
    });
</script>


    <!-- <script>
        function getEditData(id) {
            // alert(id);
            var url = "{{ route('Products_service.edit', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        // alert(data);
                        var obj = JSON.parse(data);
                        $("#editproductname").val(obj.product_name);
                        $("#editprice").val(obj.price);
                        $("#editdescription").val(obj.description);
                        $('#getid').val(obj.memberservices_id);
                        $('#memberid').val(obj.member_id);
                        $("#editphoto").val(obj.photo);
                        // alert(obj.description);
                        // $('#getid').val(obj.memberservices_id);

                    }
                });
            }
        }
    </script> -->


    <script>
        function deleteData(id) {
            // alert(id);
            $("#deleteid").val(id);
        }
    </script>

    <script>
        function chkname() {
            var name = $('#companyname').val();
            var url = "{{ route('members.checkserviceprovider') }}";
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

                        alert('Members Already Exist');
                        $('#companyname').val('');
                        $('#companyname').focus();
                        return false;

                    }
                }
            });
        }
    </script>
    <script>
        function editchkname() {
            var name = $('#Editname').val();
            var url = "{{ route('members.editcheckserviceprovider') }}";
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

                        alert('Members Already Exist');
                        $('#Editname').val('');
                        $('#Editname').focus();
                        return false;

                    }
                }
            });
        }
    </script>


@endsection
