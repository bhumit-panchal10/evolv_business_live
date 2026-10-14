
@extends('layouts.app')
@section('title', 'Connection Received List')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                
                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Connection Received
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
                                        @if($Count > 0)
                                        <div class="table-responsive scrollbar">
                                            <table class="table table-bordered table-striped fs--1 mb-0">
                                                <thead class="bg-200 text-900">
                                                    <tr>
                                                        <th scope="col">Sr No</th>                                            
                                                        <th scop="col">Given By</th>
                                                        <th scop="col">Company Name</th>
                                                        <th scop="col">Connection Name</th>
                                                        <th scop="col">Email</th>
                                                        <th scop="col">Phone Number
                                                        </th>
                                                        <th scop="col">Connection For Message</th>
                                                        <th scop="col">Connection Date</th>                                                                         
                                                        <th scop="col">Status</th>                                                                                               
                                                        {{-- <th w scop="col">Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    <?php $i = 1;                                               
                                                    ?>
                                                    @foreach ($Business as $Business1)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $Business->perPage() * ($Business->currentPage() - 1) }}
                                                            </td>
                                                           
                                                            <td class="text-center">{{ $Business1->first_name }}</td>
                                                            <td class="text-center">{{ $Business1->Company_Name ? $Business1->Company_Name : 'N/A'}}</td>
                                                            <td class="text-center">{{ $Business1->Reference_Name }}</td>
                                                            <td class="text-center">{{ $Business1->Email ? $Business1->Email : 'N/A'}}</td>
                                                            <td class="text-center">{{ $Business1->phonenumber }}</td> 
                                                            <td class="text-center">{{ $Business1->Refer_for_message ? $Business1->Refer_for_message : 'N/A' }}</td>                                                        
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($Business1->Reference_Date)->format('d-m-Y') }}
                                                            </td>
                                                            <!-- <td class="text-center"> {{ $Business1->businesscomment !== null ? $Business1->businesscomment : 'N/A' }}</td> -->
                                                            <td class="text-center">         
                                                                {{ $Business1->isapproved_status == 1 ? 'Approved' : ($Business1->isapproved_status == 2 ? 'Rejected' : '') }}
                                                            </td>                                                          
                            
                                                            <!-- <td>
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#EditModal"
                                                                    onclick="getEditData(<?= $Business1->business_id ?>)"
                                                                    class="btn btn-link p-0" title="Edit">
                                                                    <span class="text-500 fas fa-edit"></span>
                                                                </a>
                                                                <a class="btn btn-link p-0" href="#"
                                                                    data-bs-toggle="modal" title="Delete"
                                                                    data-bs-target="#deleteRecordModal"
                                                                    onclick="deleteData(<?= $Business1->business_id ?>);">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a> 
                                                                <a class="" href="#"
                                                                    data-bs-toggle="modal" title="Status Changed"
                                                                    data-bs-target="#statusModal"
                                                                    onclick="getEditDatastatus(<?= $Business1->business_id ?>);">
                                                                    <i class="fas fa-plus-square" aria-hidden="true"></i>
                                                                </a> 

                                                            </td> -->
                                                           
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>                                                                                              
                                            </table>
                                           
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                        {{$Business->links()}}
                                        </div>
                                        @else 
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                                    <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                                        <h1 class="font-white text-center"> Connection Yet To Received </h1>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog " style="background-color: white;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Business</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </button>
                        </div>
                        <form method="post" action="{{ route('Business.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-body">

                                <input type="hidden" name="business_id" id="business_id" value="">

                                <div class="row">
                                    <div class="md-3">
                                        <label for="business_from_id"><span style="color:red;">*</span>Business
                                            Type</label>
                                        <select class="form-control" name="business_type" id="Editbusiness_type"
                                            value="{{ old('business_type') }}" required>
                                            <option value="1">Direct</option>
                                            <option value="2">Reference</option>
                                        </select>
                                    </div>
                                    <div class="md-3">
                                        <label for="business_from_id"><span style="color:red;">*</span>Given By</label>
                                        <select class="form-control" name="business_from" id="Editbusiness_from"
                                            required>
                                            <option value="" selected>Select Given By</option>
                                            @foreach ($Data as $data)
                                                <option value="{{ $data->first_name }}">{{ $data->first_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="md-3">
                                        <label for="business_from_id"><span style="color:red;">*</span>Given By</label>
                                        <select class="form-control" data-choices name="business_from" id="Editbusiness_from">
                                            <option value="" selected>Given By</option>
                                            @foreach ($Data as $data)
                                                <option value="{{ $data->first_name }}">{{ $data->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}


                                    <div class="md-3">
                                        <label for="business_to_id"><span style="color:red;">*</span>Given To</label>
                                        <select class="form-control" name="business_to" id="Editbusiness_to" required>
                                            <option value="" disabled selected>Select Given By</option>
                                            @foreach ($Data as $data)
                                                <option value="{{ $data->first_name }}">{{ $data->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md-3">
                                        <span style="color:red;">*</span>Amount
                                        <input type="number" class="form-control" name="Business_amount"
                                            id="EditBusiness_amount" placeholder="Enter Business_amount"
                                            value="{{ old('Business_amount') }}" required>
                                    </div>
                                    <div class="md-3">
                                        <span style="color:red;">*</span> Business date
                                        <input type="date" class="form-control" name="business_Date"
                                            id="Editbusiness_Date" placeholder="Enter business Date" required>
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
                        <form id="user-delete-form" method="POST" action="{{ route('Business.delete') }}">
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
    {{-- @endforeach --}}

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
                    <form action="{{ route('pendinglogincheck.statuspendinglogin') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="Businessid" value="">
                        <div class="form-group">
                            <label for="newStatus">Update Status:</label>
                            {{-- {{dd($data)}} --}}
                            @if (isset($Business1->isapproved_status))
                                <!-- <select class="form-control" name="newStatus">
                                        <option value="1" {{ $Business1->isapproved_status == 1 ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="0" {{ $Business1->isapproved_status == 0 ? 'selected' : '' }}>Rejected</option>
                                    </select> -->

                                <select class="form-control" name="newStatus" id="newStatus"
                                    onchange="toggleRejectedComments()">
                                    <option value="1" {{ $Business1->isapproved_status == 1 ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="2" {{ $Business1->isapproved_status == 2 ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                            @else
                                <select class="form-control" name="newStatus">
                                    <option value="1">Approved</option>
                                    <option value="0">Pending</option>
                                </select>
                            @endif
                        </div>
                            <div class="form-group rejectedComments" id="rejectedComments" style="display : none;">
                                <label for="rejectedComments">Rejected Comments:</label>
                                <textarea class="form-control" name="businesscomment"></textarea>                
                            </div>
                  
                        <!-- <div class="form-group">
                                <label for="rejectedComments">Rejected Comments:</label>
                                <textarea class="form-control" name="rejectedComments"></textarea>
                            </div> -->
                        <button type="submit" class="btn btn-success"  style="margin-top: 20px;">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- mode end rejectedcomments --}}

@endsection

@section('scripts')

<script>
    function toggleRejectedComments() {
            let newStatus = $("#newStatus").val();
            if (newStatus == 2) {
                $("#rejectedComments").show();
            } else {
                $("#rejectedComments").hide();
            }

            var statusSelect = document.getElementById('newStatus');
            var rejectedComments = document.querySelector('.form-group.rejectedComments');

            // Hide rejectedComments by default
            rejectedComments.style.display = 'none';

            if (statusSelect.value == 2) {
                rejectedComments.style.display = 'block';
            }
        }
</script>

    <script>
        function getEditData(id) {
            // alert(id);
            var url = "{{ route('Business.edit', ':id') }}";
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
                        // console.log(data);
                        var obj = JSON.parse(data);
                        $("#Editbusiness_type").val(obj.business_type);
                        $("#Editbusiness_from").val(obj.business_from);
                        $("#Editbusiness_to").val(obj.business_to);
                        $("#EditBusiness_amount").val(obj.Business_amount);
                        $("#Editbusiness_Date").val(obj.business_Date);
                        $('#business_id').val(id);
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
        $(document).ready(function() {
            getEditData();
            // Initial state based on existing values
            if ($("#Editispaid").val() === "Yes") {
                $("#priceField").show();
            } else {
                $("#priceField").hide();
            }

            if ($("#Editlimitedset").val() === "Yes") {
                $("#setnumber").show();
            } else {
                $("#setnumber").hide();
            }

            // Trigger change event to apply initial state
            $("#Editispaid").trigger('change');
            $("#Editlimitedset").trigger('change');

            // Event listeners
            $("#Editispaid").on('change', function() {
                if ($(this).val() === "Yes") {
                    $("#priceField").show();
                } else {
                    $("#priceField").hide();
                }
            });

            $("#Editlimitedset").on('change', function() {
                if ($(this).val() === "Yes") {
                    $("#setnumber").show();
                } else {
                    $("#setnumber").hide();
                }
            });
        });
    </script>

   
    <script>
        function getEditDatastatus(id) {
            // alert(id);
            var url = "{{ route('Business.statusget', ':id') }}";
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
                        console.log(data);
                        var obj = JSON.parse(data);
                        $('#business_id').val(id);
                        $("#isapproved_status").val(obj.isapproved_status);
                        // $("#Editbusiness_from").val(obj.business_from);
                        // $("#Editbusiness_to").val(obj.business_to);
                        // $("#EditBusiness_amount").val(obj.Business_amount);
                        // $("#Editbusiness_Date").val(obj.business_Date);
                    }
                });
            }
            var name = $('#Businessid').val(id);

        }
    </script>

<script>
    function exportExcel() {
// alert('hello');
        var fromdate = $("#startdatepicker").val();
        var todate = $("#enddatepicker").val();
        // var first_name = $("#first_name").val();

        var strURL = "{{ route('Business.exportbusiness') }}";
        strURL += "/" + fromdate +"/"+todate;

        window.location.href = strURL;
    }
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>

    
    $(function() {
        $("#startdatepicker").datepicker({
            dateFormat: 'd-m-yy',
            //minDate: 0
        });

        $("#enddatepicker").datepicker({
            dateFormat: 'd-m-yy',
            //minDate: 0
        });
    });
</script>


<!-- <script>
        function RejectedComments() {

            alert('hello');
            var statusSelect = document.getElementById('newStatus');
            var rejectedComments = document.querySelector('.form-group.rejectedComments');

            if (statusSelect.value == 2) {
                rejectedComments.style.display = 'block';
            } else {
                rejectedComments.style.display = 'none';
            }
        }
    </script> -->


@endsection
