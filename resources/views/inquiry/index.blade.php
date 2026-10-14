
@extends('layouts.app')
@section('title', 'Inquiry List')
@section('content')
<style>
    .modal {
  --vz-modal-zindex: 1055;
  --vz-modal-width: 65% !important;
  --vz-modal-padding: 1.25rem;
  --vz-modal-margin: 0.5rem;
  --vz-modal-bg: #fff;
  --vz-modal-border-color: var(--vz-border-color);
  --vz-modal-border-width: 1px;
  --vz-modal-border-radius: 0.3rem;
  --vz-modal-box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  --vz-modal-inner-border-radius: calc(0.3rem - 1px);
  --vz-modal-header-padding-x: 1.25rem;
  --vz-modal-header-padding-y: 1.25rem;
  --vz-modal-header-padding: 1.25rem 1.25rem;
  --vz-modal-header-border-color: var(--vz-border-color);
  --vz-modal-header-border-width: 0;
  --vz-modal-title-line-height: 1.5;
  --vz-modal-footer-gap: 0.5rem;
  --vz-modal-footer-border-color: var(--vz-border-color);
  --vz-modal-footer-border-width: 0;
  position: fixed;
  top: 0;
  left: 0;
  z-index: var(--vz-modal-zindex);
  display: none;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: auto;
  outline: 0;
}
</style>
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
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Register Inquiry Pending List
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
                                                        <th  scop="col">Name</th>                                             
                                                        <th scop="col">Status</th>
                                                        <th scop="col">pdf</th>
                                                        <th scop="col">business establishment year pdf</th>
                                                        <th scop="col">Action</th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody class="list">
                                                    <?php $i = 1; ?>
                                                
                                                    @foreach ($inquiry as $inquiry1)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $inquiry->perPage() * ($inquiry->currentPage() - 1) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $inquiry1->reg_name }}
                                                            </td>
                                                            
                                                            <td class="text-center">
                                                                {{ $inquiry1->Status == 0 ? 'Pending' : '' }}
                                                            </td>
                                                            <!-- this code is pdf download start-->

                                                            <!-- <td class="text-center">
                                                                <a href="{{ asset('registerdocuments') . '/' . $inquiry1->documents }}" download>
                                                                    <i class="fas fa-download" aria-hidden="true"></i>
                                                                </a>
                                                            </td> -->

                                                            <!-- this code is pdf download end-->

                                                            <td class="text-center">
                                                                <a href="{{ asset('registerdocuments') . '/' . $inquiry1->documents }}" target="_blank" title="View Pdf">
                                                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ asset('business_establishment_year') . '/' . $inquiry1->business_establishment_year }}" target="_blank" title="View Pdf">
                                                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                            <td class="d-flex gap-2 justify-content-center">
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#EditModal"
                                                                    onclick="getEditData(<?= $inquiry1->id ?>)"
                                                                    class="" title="Edit">
                                                                    <span class="text-500 fas fa-edit"></span>
                                                                </a>
                                                                <a class="" href="#"
                                                                    data-bs-toggle="modal" title="Delete"
                                                                    data-bs-target="#deleteRecordModal"
                                                                    onclick="deleteData(<?= $inquiry1->id ?>);">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                                <a class="" href="#"
                                                                    data-bs-toggle="modal" title="Status Changed"
                                                                    data-bs-target="#statusModal"
                                                                    onclick="getEditDatastatus(<?= $inquiry1->id ?>);">
                                                                    <i class="fas fa-plus-square" aria-hidden="true"></i>
                                                                </a>

                                                            </td>
                                                           
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center mt-3">
                                            {{$inquiry->links()}}
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
                
              <!-- popup edit -->
              <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog " style="background-color: white;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">view Detail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </button>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-body">
                                <input type="hidden" name="business_id" id="business_id" value="">
                                <div class="row">
                                <div class="col-6">
                                    <span style="color:red;">*</span>Name
                                    <input type="text" class="form-control" name="reg_name" id="Editreg_name" placeholder="Name" value="" readonly>
                                </div>
                                <div class="col-6">
                                    <span style="color:red;">*</span>Email
                                    <input type="text" class="form-control" name="email" id="Editreg_email" placeholder="Email" value="" readonly>
                                </div>
                                <div class="col-6">
                                    <span style="color:red;">*</span>Phone Number
                                    <input type="text" class="form-control" name="phonenumber" id="Editreg_phonenumber" placeholder="Phone Number" value="" readonly>
                                </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Business segment
                                        <input type="text" class="form-control" name="reg_business_segment"
                                            id="Editreg_business_segment" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>category
                                        <input type="text" class="form-control" name="reg_category"
                                            id="Editreg_category" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Editreg businessFirm
                                        <input type="text" class="form-control" name="reg_businessFirm"
                                            id="Editreg_businessFirm" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Office Address
                                        <input type="text" class="form-control" name="reg_OfficeAddress"
                                            id="Editreg_OfficeAddress" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Other Address
                                        <input type="text" class="form-control" name="reg_Other_Address"
                                            id="Editreg_Other_Address" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Designation
                                        <input type="text" class="form-control" name="reg_designation"
                                            id="Editreg_designation" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Inception year
                                        <input type="text" class="form-control" name="reg_Inceptionyear"
                                            id="Editreg_Inceptionyear" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Average Annual Business Turnover 
                                        <input type="text" class="form-control" name="reg_annual_turnover"
                                            id="Editreg_annual_turnover" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Business Documents Brand
                                        <input type="text" class="form-control" name="business_documents_brand"
                                            id="Editbusiness_documents_brand" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>industry
                                        <input type="text" class="form-control" name="industry"
                                            id="Editindustry" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Industry Subcategory
                                        <input type="text" class="form-control" name="industry_subcategory"
                                            id="Editindustry_subcategory" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>representative_name
                                        <input type="text" class="form-control" name="representative_name"
                                            id="Editrepresentative_name" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>chapter
                                        <input type="text" class="form-control" name="chapter"
                                            id="Editchapter" 
                                            value="" readonly>
                                    </div>
                                    <div class="col-6">
                                        <span style="color:red;">*</span>Payment Mode
                                        <input type="text" class="form-control" name="payment_mode"
                                            id="Editpayment_mode" 
                                            value="" readonly>
                                    </div>
                                    <!-- <div class="md-3">
                                        <span style="color:red;">*</span>Documents
                                        <input type="text" class="form-control" name="documents"
                                            id="Editdocuments" 
                                            value="" readonly>
                                    </div> -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
      <!-- popup end -->
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
                        <form id="user-delete-form" method="POST" action="{{route('inquiry.delete')}}">
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
                  
                </div>
                <div class="modal-body">
                    <!-- Add a form for changing status and adding rejected comments -->
                    <form action="{{ route('inquiry.statuspending') }}" method="post">
                        @csrf
                        <input type="hidden" name="Editpending_id" id="Editpending_id" value="">
                        <div class="form-group">
                            <label for="newStatus">Update Status:</label>
                            {{-- {{dd($data)}} --}}
                            @if (isset($inquiry1->status)) 
                                <!-- <select class="form-control" name="newStatus">
                                        <option value="1" {{ $Business1->isapproved_status == 1 ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="0" {{ $Business1->isapproved_status == 0 ? 'selected' : '' }}>Rejected</option>
                                    </select> -->

                                <select class="form-control" name="newStatus" id="newStatus"
                                    onchange="toggleRejectedComments()">
                                    <option value="0" {{ $inquiry1->isapproved_status == 0 ? 'selected' : '' }}>
                                        pending</option>
                                    <option value="1" {{ $inquiry1->isapproved_status == 1 ? 'selected' : '' }}>
                                        Approved</option>
                                </select>
                            @else
                                <select class="form-control" name="newStatus">
                                    <option value="1">Approved</option>
                                    <option value="0">Pending</option>
                                </select>
                            @endif
                        </div>                    
                        <button type="submit" class="btn btn-success" style="margin-top: 20px;">Save</button>
                        <button type="button" class="btn btn-success" style="margin-top: 20px;" onclick="$('#statusModal').modal('hide')">
                        Close
                    </button>
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
            var url = "{{ route('inquiry.edit', ':id') }}";
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
                        $("#Editreg_name").val(obj.reg_name);
                        $("#Editreg_email").val(obj.email);
                        $("#Editreg_phonenumber").val(obj.phonenumber);
                        $("#Editreg_business_segment").val(obj.reg_business_segment);
                        $("#Editreg_category").val(obj.reg_category);
                        $("#Editreg_businessFirm").val(obj.reg_businessFirm);
                        $("#Editreg_OfficeAddress").val(obj.reg_OfficeAddress);
                        $("#Editreg_Other_Address").val(obj.reg_Other_Address);
                        $("#Editreg_designation").val(obj.reg_designation);
                        $("#Editreg_Inceptionyear").val(obj.reg_Inceptionyear);
                        $("#Editreg_annual_turnover").val(obj.reg_annual_turnover);
                        $("#Editbusiness_documents_brand").val(obj.business_documents_brand);
                        $("#Editindustry").val(obj.name);
                        $("#Editindustry_subcategory").val(obj.industry_subcategory);
                        $("#Editrepresentative_name").val(obj.representative_name);
                        $("#Editchapter").val(obj.chapter);
                        $("#Editpayment_mode").val(obj.payment_mode);
                        $("#Editdocuments").val(obj.documents);
                        $("#EditStatus").val(obj.Status);
                        $('#Editinquery_id').val(id);
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
            $("#Editpending_id").val(id);
                      
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
