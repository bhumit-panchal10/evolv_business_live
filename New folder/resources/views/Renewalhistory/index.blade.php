
@extends('layouts.app')
@section('title', 'Renewal History ')
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
                        <!-- <div class="card-header">
                            <h5 class="card-title mb-0">Renewal History List</h5>
                        </div> -->
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Renewal History List
                                    </h5>
                                </div>
                                <div>Member Name:-{{$username->first_name}}
                                    <!-- <a href="{{ URL::previous() }}" style="background: #404042 !important;
                                    color: white;
                                    border: none;" class="btn btn-success">Back</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php //echo date('ymd');
                            ?>
                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Plan Name</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>  
                                        <th scope="col">Amount</th>  
                                        <th scope="col">Action</th>                 
                                       
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    <?php $i = 1; ?>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class="text-center">
                                                {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                               <!-- <td class="text-center">{{ $data->first_name }}</td>  -->
                                               <td class="text-center">{{ $data->plan_name }}</td> 
                                               <td class="text-center">{{ date('d-m-y', strtotime($data->substartdate)) }}</td>
                                               <td class="text-center">{{ date('d-m-y', strtotime($data->stbenddate)) }}</td>
                                               <td class="text-center">{{$data->amount}}</td>
                                                <!-- <td class="text-center">{{ $data->price }}</td> -->
                                            <td>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    {{-- <a href="{{ route('Products_service.edit',$data->memberservices_id)}}">
                                                            <i class="far fa-edit"></i>
                                                        </a> --}}

                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a class="mx-1" title="Add" href="#"
                                                            onclick="getEditData(<?= $data->member_id ?>)"
                                                            data-bs-toggle="modal" data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>

                                                        <a class="" href="#" data-bs-toggle="modal"
                                                            title="Delete" data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $data->renewal_history_id ?>);">
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Renewal History</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form method="POST" onsubmit="return EditvalidateFile()"
                            action="{{ route('Renewalhistory.update') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="getid">
                            <input type="hidden" name="member_id" id="memberid">


                            <div class="modal-body">
                                @if(isset($data->plan_id))
                                <div>
                                    <label for="plan_id"><span style="color:red;">*</span> Plan Name</label>
                                    <select class="form-control" name="plan_id" id="plan_id" required>
                                        <option value="" disabled>Select Plan Name</option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}" {{ $plan->id == $data->plan_id ? 'selected' : '' }}>
                                                {{ $plan->plan_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                <div>
                                    <label for="plan_id"><span style="color:red;">*</span> Plan Name</label>
                                    <select class="form-control" name="plan_id" id="plan_id" required>
                                        <option value="" selected>Select Plan Name</option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->plan_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                  
                                @endif   

                                <div class="row gy-3 mb-3">
                               
                                    <div class="col-lg-12 col-md-6">
                                    <span style="color:red;">*</span> renewal_date
                                                <input type="date" class="form-control" name="renewal_date"
                                                    id="renewal_date" placeholder="Enter renewal date" required>
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
            </div>
            <!--Edit Modal End -->


    

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
                                    action="{{ route('Renewalhistory.delete') }}">
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
@endsection

@section('scripts')

    <script>
        function getEditData(id) {
            // alert(id);
            var url = "{{ route('Renewalhistory.edit', ':id') }}";
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
                        $('#getid').val(obj.renewal_history_id);
                        $('#memberid').val(obj.member_id);
                        $('#plan_id').val(obj.plan_id);
                        
                        // alert(obj.description);
                        // $('#getid').val(obj.memberservices_id);
                       
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
