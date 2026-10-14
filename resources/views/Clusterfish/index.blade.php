@extends('layouts.app')
@section('title', 'Product Inquiry List')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                {{-- Alert Messages --}}
                @include('common.alert')
                <!--search start-->
                  <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <form method="post" id="form" action="{{ route('Clusterfish.index') }}">
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
                                            <div class="input-group d-flex" style="justify-content: space-around;">
                                                <input type="submit" id="search" class="btn btn-success" name="search"
                                                    title="Search" value="Search">
                                                <button type="button" id="cancel_search"
                                                    class="btn btn-success ">Cancel</button>

                                                <button class="btn btn-success" type="button" onclick="exportExcel();">
                                                    <i class="fa-solid fa-file-excel fa-xl"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--search end-->
                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor"> Cluster Fest List
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
                                        @if ($Count > 0)
                                            <div class="table-responsive scrollbar">
                                                <table class="table table-bordered table-striped fs--1 mb-0">
                                                    <thead class="bg-200 text-900">
                                                        <tr>
                                                            <th scope="col" style="padding-left: 20px; padding-right: 20px;">Sr No</th>
                                                            <th scop="col" style="padding-left: 30px; padding-right: 30px;">Name</th>
                                                            <th scop="col">Brand Name</th>
                                                            <th scop="col">Email</th>
                                                            <th scop="col">City</th>
                                                            <th scop="col">Phone number</th>
                                                            <th scop="col">Buisness Category</th>
                                                            <th scop="col">Buisness Profile in Brief</th>
                                                            <th scop="col">Buisness Model</th>
                                                            <th scop="col">Referred By</th>
                                                            <th scop="col">Reference_name</th>
                                                            <th scop="col" style="padding-left: 25px; padding-right: 25px;">Payment Date</th>
                                                            <th scop="col">Payment Status</th>
                                                            <th scop="col">Payment Status update</th>
                                                            <th scop="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list">
                                                        <?php $i = 1; ?>
                                                        
                                                        @foreach ($Clusterfish as $data)
                                                            <tr>
                                                                <td class="text-center">
                                                                    {{ $i + $Clusterfish->perPage() * ($Clusterfish->currentPage() - 1) }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $data->name ?? '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $data->Brand_name ?? '-' }}
                                                                </td>
                                                                 <td class="text-center">
                                                                    {{ $data->email ?? '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $data->City ?? '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $data->Phonenumber ?? '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $data->Buisness_Category ?? '-' }}
                                                                </td>

                                                                <td class="text-center">
                                                                    {{ $data->Buisness_Profile_in_Brief_ ?? '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $data->Buisness_Model ?? '-' }}
                                                                </td>

                                                                <td class="text-center">
                                                                    {{ $data->Referred_By ?? '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $data->reference_name ?? '-' }}
                                                                </td>
                                                                 <td class="text-center">
                                                                    {{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d-m-y') : 'N/A' }}
                                                                </td>  
                                                                <td class="text-center">
                                                                    @if ($data->Payment_Status == 0)
                                                                        <span style="color: blue;">Pending</span>
                                                                    @elseif($data->Payment_Status == 1)
                                                                        <span style="color: green;">Success</span>
                                                                    @elseif($data->Payment_Status == 3)
                                                                        <span style="color: red;">Fail</span>
                                                                    @else
                                                                        <span style="color: gray;">Unknown Status</span>
                                                                    @endif
                                                                </td>
                                                                 <td class="">
                                                                    <a href="#" class="" data-bs-toggle="modal"
                                                                        data-bs-target="#updateStatusModal"
                                                                        onclick="setPaymentStatus({{ $data->id }}, {{ $data->Payment_Status }});">
                                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                                    </a>
                                                                </td>

                                                                <td class="d-flex gap-2 justify-content-center">
                                                                    <a class="" href="#" data-bs-toggle="modal"
                                                                        title="Delete" data-bs-target="#deleteRecordModal"
                                                                        onclick="deleteData(<?= $data->id ?>);">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php $i++; ?>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center mt-3">
                                                {{ $Clusterfish->links() }}
                                            </div>
                                        @else
                                            <div class="row">
                                                <div
                                                    class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                                    <div
                                                        class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
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
                                <form id="user-delete-form" method="POST" action="{{ route('Clusterfish.delete') }}">
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
            <!--payment status-->
            <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateStatusModalLabel">Update Payment Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('Clusterfish.ClusterfestpaymentStatus') }}" method="post">
                                @csrf
                                <input type="hidden" name="paymentRecordId" id="paymentRecordId" value="">
                                <div class="form-group">
                                    <label for="paymentStatus">Payment Status</label>
                                    <select class="form-control" id="paymentStatus" name="payment_status">
                                        <option value="0">Pending</option>
                                        <option value="1">Success</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

         <!--payment status-->

        @endsection
        
        @section('scripts')
            <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

            <script>
                $(function() {
                    $("#startdatepicker").datepicker({
                        dateFormat: 'd-m-yy',
                        //minDate: 0
                    });
                });

                $(function() {
                    $("#enddatepicker").datepicker({
                        dateFormat: 'd-m-yy',
                        //minDate: 0
                    });
                });
            </script>

            <script>
                function deleteData(id) {
                    $("#deleteid").val(id);
                }
            </script>
             <script>
                $(document).ready(function() {
                    $('#cancel_search').click(function() {
                        $('#startdatepicker').val('');
                        $('#enddatepicker').val('');
                        $('#form').submit();
                    });
                });
            </script>
            <script>
                function exportExcel() {
                    var fromdate = $("#startdatepicker").val();
                    var todate = $("#enddatepicker").val();
                    var strURL = "{{route('Clusterfish.Clusterfestexport')}}";
                    strURL += "?fromdate="+fromdate+"&todate="+todate;
                    window.location.href = strURL;
                }
            </script>  
             <script>
                function setPaymentStatus(id, Payment_Status) {
                    $("#paymentRecordId").val(id);
                    $("#paymentStatus").val(Payment_Status);
                }
            </script>


        @endsection

