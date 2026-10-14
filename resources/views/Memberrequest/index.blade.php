
@extends('layouts.app')
@section('title', 'Pending List')
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
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Member Podcast
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
                                            <table class="table table-bordered table-striped fs--1 mb-0">
                                                <thead class="bg-200 text-900">
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th  scop="col">Member Name</th>                                             
                                                        <th scop="col">Book Podcast Date</th>                        
                                                        <!-- <th scop="col">Book Member of the week Date</th> -->
                                                        <th scop="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    <?php $i = 1; ?>
                                                    @foreach ($datas as $datas1)
                                                        <tr>
                                                        <td class="text-center">
                                                            {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}
                                                        </td>                                          
                                                            <td class="text-center">{{ $datas1->first_name }}</td>
                                                                                               
                                                            <td class="text-center">                                                         
                                                                {{ \Carbon\Carbon::parse($datas1->Book_Your_Podcast)->format('d-m-Y') }}
                                                            </td>
                                                            <!-- <td class="text-center">                                                             
                                                               
                                                                {{ \Carbon\Carbon::parse($datas1->Book_Your_Member_of_the_week)->format('d-m-Y') }}
                                                            </td>                                                           -->
                                                            <td>   
                                                            <a class="btn btn-link p-0 text-black" href="#"
                                                                    data-bs-toggle="modal" title="Delete"
                                                                    data-bs-target="#deleteRecordModal"
                                                                    onclick="deleteData(<?= $datas1->memberid ?>);">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>                                                                                                    
                                                                <a class="" href="#" data-bs-toggle="modal" title="Status Changed" data-bs-target="#statusModal" onclick="getEditDatastatus(<?= $datas1->memberid ?>);">
                                                                    <i class="fas fa-plus-square" aria-hidden="true"></i>
                                                                </a>
                                                             </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        <div class="d-flex justify-content-center mt-3">
                                        {{$datas->links()}}
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
                        <form id="user-delete-form" method="POST" action="{{ route('Memberrequest.delete') }}">
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


    <!-- Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Member podcast date
                        </h5>
                    
                </div>
                <div class="modal-body">
                    <form action="{{route('Memberrequest.status')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="" id="member_id">
                        <input type="hidden" name="user_id" value="" id="user_id">
                        <div class="form-group">
                            <label for="member_podcast_date">Member podcast Date:</label>
                            <input type="text" name="member_podcast_date" class="form-control" id="Book_Your_Podcast">
                        </div>
                        <div class="col-lg-3 col-md-3">
                        <div class="d-flex align-items-center gap-1">
                        <button type="submit" class="btn btn-success" style="margin-top: 20px;">Save</button>
                        <button type="button" class="btn btn-light" style="margin-top: 20px;" onclick="$('#statusModal').modal('hide')">
                        Close
                    </button>
                    </div>
            </div>
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
            var url = "{{ route('Memberrequest.statusget1', ':id') }}";
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
                        $('#member_id').val(id);
                        $("#Book_Your_Podcast").val(obj.Book_Your_Podcast);
                        $("#user_id").val(obj.user_id);

                       
                    }
                });
            }
            var name = $('#member_id').val(id);

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
            minDate: 0
        });

        $("#enddatepicker").datepicker({
            dateFormat: 'd-m-yy',
            minDate: 0
        });
    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {
        $("#Book_Your_Podcast").datepicker({
            dateFormat: "yy-mm-dd",
            //minDate: 0
        });      
    });
</script>

@endsection
