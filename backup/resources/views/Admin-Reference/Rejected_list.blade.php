
@extends('layouts.app')
@section('title', 'rejected List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
               
                {{-- Alert Messages --}}
                @include('common.alert')

                {{-- Tab start  --}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-success mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " href="{{ route('Admin-Reference.index') }}">
                                        <i class="fas fa-clock"></i> Pending
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ route('Admin-Reference.Approve_list') }}" role="tab"
                                        aria-selected="false" tabindex="-1">
                                        <i class="fas fa-check-circle"></i> Approved
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" href="{{ route('Admin-Reference.Rejected_list') }}" role="tab"
                                        aria-selected="false" tabindex="-1">
                                        <i class="fas fa-times-circle"></i>Rejected
                                    </a>
                                </li>
                            </ul>
                        </div><!-- end card-body -->
                    </div>
                </div>
                {{-- Tab End  --}}
                {{-- start search  --}}
                <div class="col-lg-12">
                    <div class="card">
                       
                        <div class="card-body">
                            <form method="post" id="form" action="{{ route('Business.rejected_list') }}">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter From Date" type="text" class="form-control"
                                                id="startdatepicker" name="fromdate" autocomplete="off"
                                                value="<?= isset($FromDate) ? $FromDate : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter To Date" type="text" class="form-control"
                                                name="todate" autocomplete="off" id="enddatepicker"
                                                value="<?= isset($ToDate) ? $ToDate : '' ?>">
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-3 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="input-group d-flex">
                                                <input type="submit" id="search" class="btn btn-success mx-2" name="search"
                                                    title="Search" value="Search">  
                                                    <button type="button" id="cancel_search" class="btn btn-success">Cancel</button>
                                            </div> 
                                        </div>
                                    </div>
                                    
                                         <!-- <div class="col-md-3 mb-2 text-end">
                                                <button class="btn btn-success" type="button" onclick="exportExcel();">
                                                        <i class="fa-solid fa-file-excel fa-xl"></i>
                                                    </button>
                                            </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end search --}}

                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Connection Rejected List
                                    </h5>
                                </div>
                                <div>
                                    <a href="{{ route('Admin-Reference.storeview') }}" class="btn btn-success">Add Connection</a>
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
                                                        <th width="5%" data-sort="Date">Given By</th>
                                                        <th width="5%" data-sort="Date">Given To</th>
                                                        <th width="5%" data-sort="Date">Company Name</th>
                                                        <th width="5%" data-sort="Date">Contact person </th>
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
                                                           <td class="text-center">{{ $Business1->Reference_from }}</td>
                                                            <td class="text-center">{{ $Business1->Reference_to }}</td>
                                                            <td class="text-center">{{ $Business1->Company_Name ? $Business1->Company_Name : 'N/A' }}</td>
                                                            <td class="text-center">{{ $Business1->Reference_Name }}</td>
                                                            <td class="text-center">{{ $Business1->Email ? $Business1->Email : 'N/A'}}</td>
                                                            <td class="text-center">{{ $Business1->phonenumber }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse( $Business1->Reference_Date)->format('d-m-Y') }}</td>
                                                            <td class="text-center">{{ $Business1->Refer_for_message ? $Business1->Refer_for_message : 'N/A' }}</td>
                                                            <td class="text-center"> {{ $Business1->Referencecomment !== null ? $Business1->Referencecomment : 'N/A' }}</td>
                                                            <td class="text-center">
                                                                {{ $Business1->isapproved_status == 2 ? 'Rejected' : '' }}
                                                            </td>

                                                            <td class="d-flex gap-2 justify-content-center">
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#EditModal"
                                                                    onclick="getEditData(<?= $Business1->Reference_id ?>)"
                                                                    class="" title="Edit">
                                                                    <span class="text-500 fas fa-edit"></span>
                                                                </a>
                                                                <a class="" href="#"
                                                                    data-bs-toggle="modal" title="Delete"
                                                                    data-bs-target="#deleteRecordModal"
                                                                    onclick="deleteData(<?= $Business1->Reference_id ?>);">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                                <a class="" href="#"
                                                                    data-bs-toggle="modal" title="Status Changed"
                                                                    data-bs-target="#statusModal"
                                                                    onclick="getEditDatastatus(<?= $Business1->Reference_id ?>);">
                                                                    <i class="fas fa-plus-square" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php $i++;                                                         
                                                        ?>
                                                    @endforeach
                                                </tbody>                                               
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">                                   
                                        {{ $Business->appends(['fromdate' => $FromDate,'todate' => $ToDate,])->links() }}
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
                        <form method="post" action="{{ route('Admin-Reference.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-body">
                                <input type="hidden" name="Reference_id" id="Reference_id" value="">
                                    <div class="md-3 mb-2">
                                        <label for="business_from_id"><span style="color:red;">*</span>Given By</label>
                                        <select class="form-control" name="Reference_from" id="Editbusiness_from"
                                            required>
                                            <option value="" selected>Select Given By</option>
                                            @foreach ($Data as $data)
                                                <option value="{{ $data->id }}">{{ $data->first_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                                  
                                    <div class="md-3 mb-2">
                                        <label for="business_to_id"><span style="color:red;">*</span>Given To</label>
                                        <select class="form-control" name="Reference_to" id="Editbusiness_to" required>
                                            <option value="" disabled selected>Select Given By</option>
                                            @foreach ($Data as $data)
                                                <option value="{{ $data->id}}">{{ $data->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- new -->
                                    <div class="md-3 mb-2">
                                        <label for="Reference_Name"><span style="color:red;">*</span>Contact person</label>                                       
                                        <input class="form-control" id="EditReference_Name" name="Reference_Name" type="text"
                                            placeholder="Enter Reference Name" value="{{ old('Reference_Name') }}" required>
                                    </div>   
                                    <div class="md-3 mb-2">
                                    <label for="Company_Name"><span style="color:red;">*</span> Company Name</label>                                       
                                        <input type="Text" class="form-control" name="Company_Name"
                                            id="EditCompanyName" placeholder="Enter Company Name " required>
                                    </div>  
                                    <div class="md-3 mb-2">
                                    <label for="phonenumber"><span style="color:red;">*</span> Phone number</label>                                      
                                        <input type="phonenumber" class="form-control" name="phonenumber"
                                            id="Editphonenumber" placeholder="Enter phonenumber  " oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" maxlength="10" minlength="10" value="{{old('phonenumber')}}"required>
                                    </div>      
                                    <div class="md-3 mb-2">
                                         <label for="Email"><span style="color:red;">*</span>Email</label>                                     
                                        <input type="Text" class="form-control" name="Email"
                                            id="EditEmail" placeholder="Enter Email  " required>
                                    </div>  
                                    <div class="md-3 mb-2">
                                    <label for="Refer_for_message"><span style="color:red;">*</span>Refer for message</label>                                      
                                        <input type="Text" class="form-control" name="Refer_for_message"
                                            id="Refer_for_message" placeholder="Enter Refer for message"maxlength="50" required>
                                    </div>                       
                                    <!-- new -->  
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
                        <form id="user-delete-form" method="POST" action="{{ route('Admin-Reference.deleterejected') }}">
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
                        </h5>
                    <button type="button" class="btn btn-light" onclick="$('#statusModal').modal('hide')">
                        Close
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add a form for changing status and adding rejected comments -->
                    <form action="{{ route('Admin-Reference.status') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="Referenceid" value="">
                        <div class="form-group">
                            <label for="newStatus">Update Status:</label>
                          
                            @if (isset($Business1->isapproved_status))
                               
                                <select class="form-control" name="newStatus" id="newStatus">
                                    <!-- onchange="toggleRejectedComments()" -->
                                    <option value="0" {{ $Business1->isapproved_status == 0 ? 'selected' : '' }}>
                                    Pending</option>
                                    <option value="1" {{ $Business1->isapproved_status == 1 ? 'selected' : '' }}>
                                    Approved</option>
                                </select>
                            @else
                                <select class="form-control" name="newStatus">
                                    <option value="1">Approved</option>
                                    <option value="0">Pending</option>
                                </select>
                            @endif
                        </div>                     
                        <button type="submit" class="btn btn-success mt-3" >Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- mode end rejectedcomments --}}

@endsection

@section('scripts')
<script>
        function getEditData(id) {
            // alert(id);
            var url = "{{ route('Admin-Reference.edit', ':id') }}";
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
                        // $("#Editbusiness_type").val(obj.business_type);
                        $("#Editbusiness_from").val(obj.Reference_from);
                        $("#Editbusiness_to").val(obj.Reference_to);
                        $("#EditReference_Name").val(obj.Reference_Name);
                        $("#EditCompanyName").val(obj.Company_Name);
                        $("#Refer_for_message").val(obj.Refer_for_message);
                        $("#Editphonenumber").val(obj.phonenumber);
                        $("#EditEmail").val(obj.Email);
                        $('#Reference_id').val(id);
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
            var name = $('#Referenceid').val(id);
        }
    </script>

<script>
    function exportExcel() {
// alert('hello');
        var fromdate = $("#startdatepicker").val();
        var todate = $("#enddatepicker").val();
        // var first_name = $("#first_name").val();

        var strURL = "{{ route('Business.exportrejected') }}";
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

<script>
    $(document).ready(function(){
        // Add click event listener to the cancel button
        $('#cancel_search').click(function(){
            // Reset the value of the category_id select element to empty
            $('#startdatepicker').val('');
            $('#enddatepicker').val('');

            // Submit the form to fetch all data
            $('#form').submit();
        });
    });
</script>
@endsection
