@extends('layouts.app')
@section('title', 'Membership plan List')
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
                                <h5 class="card-title mb-0">Add Membership plan</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('membershipplans.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-5" style="align-items: end;">
                                            <div class="col-lg-12">
                                                <div class="pt-3">
                                                    <span style="color:red;">*</span> Membership Plan Name
                                                    <input type="text" class="form-control" name="plan_name"
                                                        id="plan_name" placeholder="Enter Membership Plan Name" maxlength="100"
                                                        autocomplete="off" value="{{old('plan_name')}}" required>
                                                </div>

                                                <!-- Add new fields here -->
                                                <div class="pt-3">
                                                    <span style="color:red;">*</span> Duration in Days
                                                    <input type="number" class="form-control" name="duration_in_days"
                                                        id="duration_in_days" placeholder="Enter Duration in Days" value="{{old('duration_in_days')}}" required>
                                                </div>

                                                <div class="pt-3">
                                                    <span style="color:red;">*</span> Amount
                                                    <input type="number" class="form-control" name="amount" id="amount"
                                                        placeholder="Enter Amount" value="{{old('amount')}}" required>
                                                </div>

                                                <div class="pt-3">
                                                    <span style="color:red;">*</span> Discount%
                                                    <input type="number" class="form-control" name="discount"
                                                        id="discount" placeholder="Enter Discount" value="{{old('discount')}}" required>
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
                                <h5 class="card-title mb-0">Membership Plan List</h5>
                            </div>
                            <div class="card-body">
                                <?php //echo date('ymd');
                                ?>
                                @if($Count > 0 )
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No</th>
                                            <th scope="col">Membership plan name</th>
                                            <th scope="col">Duration in Days</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Discount%</th>
                                            <th scope="col">Discount Amount</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">  {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                <td class="text-center">{{ $data->plan_name }}</td>
                                                <td class="text-center">{{ $data->duration_in_days }}</td>
                                                <td class="text-center">{{ $data->amount }}</td>
                                                <td class="text-center">{{ $data->discount }}</td>
                                                <td class="text-center">{{ $data->discountamout }}</td>
                                                
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
             
                <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Membership Plan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            <form method="POST" onsubmit="return EditvalidateFile()"
                            action="{{ route('membershipplans.update') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="getid" value="">
                
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <span style="color:red;">*</span> Membership Plan Name
                                        <input type="text" class="form-control" onblur="editchkname();" name="plan_name" id="Editname" maxlength="100" autocomplete="off"  placeholder=" Enter Membership plan">
                                    </div>
                
                                    <!-- Add new fields for editing here -->
                
                                    <div class="mb-3">
                                        <span style="color:red;">*</span> Duration in Days
                                        <input type="number" class="form-control" name="duration_in_days" id="Editduration" placeholder="Enter Duration in Days">
                                    </div>
                
                                    <div class="mb-3">
                                        <span style="color:red;">*</span> Amount
                                        <input type="number" class="form-control" name="amount" id="Editamount" placeholder="Enter Amount">
                                    </div>
                
                                    <div class="mb-3">
                                        <span style="color:red;">*</span> Discount%
                                        <input type="number" class="form-control" name="discount" id="Editdiscount" placeholder="Enter Discount">
                                        
                                    </div>
                                </div>
                                <!-- <div class="mb-3">
                                <span style="color:red;">*</span> Discount
                                <div class="input-group">
                                    <input type="number" class="form-control" name="discount" id="Editdiscount" placeholder="Enter Discount">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div> -->

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
                                        action="{{ route('membershipplans.delete') }}">
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
        var url = "{{ route('membershipplans.edit', ':id') }}";
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
                    $("#Editname").val(obj.plan_name);
                    $("#Editduration").val(obj.duration_in_days);
                    $("#Editamount").val(obj.amount);
                    $("#Editdiscount").val(obj.discount);
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

    <script>
        function chkname() {
            var name = $('#plan_name').val();
            var url = "{{ route('membershipplans.checkserviceprovider') }}";
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

                        alert('Membership Plans Already Exist');
                        $('#plan_name').val('');
                        $('#plan_name').focus();
                        return false;

                    }
                }
            });
        }
    </script>
    <script>
        function editchkname() {
            var name = $('#Editname').val();
            var url = "{{ route('membershipplans.editcheckserviceprovider') }}";
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

                        alert('Membership Plans Already Exist');
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

