
@extends('layouts.app')
@section('title', 'Connection  List')
@section('content')
<?php $session = auth()->user(); ?>
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
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Connection Given
                                    </h5>
                                </div>
                                <div>
                                <a href="#" data-bs-toggle="modal"
                                       data-bs-target="#EditModal1"
                                       onclick="referencegetData()"
                                       class="btn btn-success" title="">Give New Connection
                                </a>                                                             
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
                                                        <th width="2%" data-sort="Title">Sr No</th>
                                                        <th width="5%" data-sort="Date">Given To</th>
                                                        <th width="5%" data-sort="Date">Company Name</th>
                                                        <th width="5%" data-sort="Date">Connection Name</th>
                                                        <th width="5%" data-sort="Date">Email</th>
                                                        <th width="5%" data-sort="Date">Phone Number
                                                        </th>
                                                        <th width="5%" data-sort="Date">Connection Date</th>
                                                        <th width="5%" data-sort="Date">Connection For Message</th>
                                                        <th width="5%" data-sort="Date">Rejected Comment</th>
                                                        <th width="5%" data-sort="Date">Status</th>
                                                        
                                                        <th width="5%" data-sort="Action">Action</th>
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

                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($Business1->Reference_Date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="text-center">{{ $Business1->Refer_for_message ? $Business1->Refer_for_message : 'N/A' }}</td>
                                                            <td class="text-center"> {{ $Business1->Referencecomment !== null ? $Business1->Referencecomment : 'N/A' }}</td>
                                                            <td class="text-center">
                                                            {{ $Business1->isapproved_status == 0 ? 'Pending' : ($Business1->isapproved_status == 1 ? 'Approved' : 'Rejected') }}
                                                            </td>

                                                            <td class="text-center">
                                                                @if($Business1->isapproved_status == 0) <!-- Check if status is pending -->
                                                                    <!-- <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#EditModal"
                                                                    onclick="getEditData(<?= $Business1->Reference_id ?>)"
                                                                    class="" title="Edit">
                                                                        <span class="text-500 fas fa-edit"></span>
                                                                    </a> -->
                                                                    <a class="" href="#"
                                                                    data-bs-toggle="modal" title="Delete"
                                                                    data-bs-target="#deleteRecordModal"
                                                                    onclick="deleteData(<?= $Business1->Reference_id ?>);">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </a>
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                           
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
                                                        <h1 class="font-white text-center"> Connection Yet To Give </h1>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Connection</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </button>
                        </div>
                        <form method="post" action="{{ route('Reference.update') }}" enctype="multipart/form-data">
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
                                    <!-- <div class="md-3">
                                        <label for="business_from_id"><span style="color:red;">*</span>Given By</label>
                                        <select class="form-control" name="business_from" id="Editbusiness_from"
                                            required>
                                            <option value="" selected>Select Given By</option>
                                            @foreach ($Data as $data)
                                                <option value="{{ $data->first_name }}">{{ $data->first_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> -->

                                    {{-- <div class="md-3">
                                        <label for="business_from_id"><span style="color:red;">*</span>Given By</label>
                                        <select class="form-control" data-choices name="business_from" id="Editbusiness_from">
                                            <option value="" selected>Given By</option>
                                            @foreach ($Data as $data)
                                                <option value="{{ $data->first_name }}">{{ $data->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                              <!-- this same user name not select code start -->
                                    <div class="md-3">
                                        <label for="business_to_id"><span style="color:red;">*</span>Given To</label>
                                        <select class="form-control" name="business_to" id="Editbusiness_to" required>
                                            <option value="" disabled selected>Select Given By</option>
                                            @foreach ($Data as $data)
                                                @if ($data->id !== $session->id) {{-- Check if the user is not the currently logged-in user --}}
                                                    <option value="{{ $data->first_name }}">{{ $data->first_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                              <!-- this same user name not select code end -->
                                
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
                        <form id="user-delete-form" method="POST" action="{{ route('Reference.delete') }}">
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
                    <h5 class="modal-title" id="statusModalLabel">Change Status and Add Rejected
                        Comments</h5>
                    <button type="button" class="btn btn-light" onclick="$('#statusModal').modal('hide')">
                        Close
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add a form for changing status and adding rejected comments -->
                    <form action="{{ route('Business.status') }}" method="post">
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
                            @foreach($Business as $business)
                            <div class="form-group rejectedComments"
                                style="display: {{ $business->isapproved_status == 2 ? 'block' : 'none' }}">
                                <label for="rejectedComments">Rejected Comments:</label>
                                <textarea class="form-control" name="businesscomment"></textarea>
                            </div>
                        @endforeach

                        <!-- <div class="form-group">
                                <label for="rejectedComments">Rejected Comments:</label>
                                <textarea class="form-control" name="rejectedComments"></textarea>
                            </div> -->
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- mode end rejectedcomments --}}


    <!-- add model start -->
    <div class="modal fade" id="EditModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " style="background-color: white;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Connection</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </button>
                        </div>
                        <form method="post" action="{{ route('Reference.create') }}" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-body">
                                <input type="hidden" name="" id="" value="">
                                <div class="row">
                                    <div class="mb-3" >
                                        <label for="Reference_to"><span style="color:red;">*</span>Given To</label>
                                        <select class="form-control" data-choices name="Reference_to" id="choices-single-default">
                                            <option value="" disabled selected>Select Given To</option>
                                            @foreach ($Data as $data)
                                                @if ($data->id !== $session->id) 
                                                    <option value="{{ $data->id }}">{{ $data->first_name }} - ({{$data->mobile_number}})</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3" >
                                        <span style="color:red;">*</span>Connection Name</label>
                                        <input class="form-control" id="Editname" name="Reference_Name" type="text"
                                            placeholder="Enter Connection Name" value="{{ old('Reference_Name') }}" required>
                                        </div><br>                                    
                                    </div>
                                    <div class="mb-3" >
                                        <span style="color:red;"></span>Company Name
                                        <input type="Text" class="form-control" name="Company_Name"
                                            id="Company_Name" placeholder="Enter Company Name " >
                                    </div>
                                    <div class="mb-3" >
                                        <span style="color:red;">*</span>Phone number
                                        <input type="phonenumber" class="form-control" name="phonenumber"
                                            id="phonenumber" placeholder="Enter phonenumber  " oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" maxlength="10" minlength="10" value="{{old('phonenumber')}}"required>
                                    </div>
                                    <div class="mb-3" >
                                        <span style="color:red;"></span>Email
                                        <input type="Text" class="form-control" name="Email"
                                            id="Email" placeholder="Enter Email  ">
                                    </div>
                                   
                                    <div class="mb-3" >
                                        <span style="color:red;"></span>Refer for message
                                        <input type="Text" class="form-control" name="Refer_for_message"
                                            id="Refer_for_message" placeholder="Enter Refer for message"maxlength="50" >
                                    </div>
                                    <!-- <div class="mb-3" >
                                        <span style="color:red;">*</span> Reference date
                                        <input type="date" class="form-control" name="Reference_Date"
                                            id="Reference_Date" placeholder="Enter Reference Date" required>
                                    </div> -->
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
    <!-- add model end -->

@endsection

@section('scripts')
    <script>
        function getEditData(id) {
            // alert(id);
            var url = "{{ route('Reference.edit', ':id') }}";
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
    function referencegetData() {
        var url = "{{ route('Reference.storeview') }}";

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                var obj = JSON.parse(data);
                $("#id").val(obj.id);
                $("#Editfirst_name").val(obj.first_name);
                $("#Editbusiness_to").val(obj.business_to);
                $("#EditBusiness_amount").val(obj.Business_amount);
                $("#Editbusiness_Date").val(obj.business_Date);
              
                $('#business_id').val(obj.id);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
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
    <script>
        function getEditDatastatus(id) {
            // alert(id);
            var name = $('#Businessid').val(id);
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



@endsection
