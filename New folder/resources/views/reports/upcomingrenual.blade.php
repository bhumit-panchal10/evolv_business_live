@extends('layouts.app')

@section('title', 'Payment report')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">   
                <div class="mt-3">
                    <!-- Page Heading -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" id="form" action="{{ route('reports.upcomingrenual') }}">
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
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="first_name"
                                                    placeholder="Member Name" id="first_name"
                                                    value="<?= isset($firstname) ? $firstname : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div>
                                                <input type="submit" id="search" class="btn btn-success" name="search"
                                                    title="Search" value="Search">
                                                    <button type="button" id="cancel_search" class="btn btn-success ">Cancel</button>
                                            </div>
                                            @include('common.alert')
                                            {{-- <div class="row">
                                                <div class="col-12">
                                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                        <button class="btn btn-success" type="button" onclick="exportExcel();">
                                                            <i class="fa-solid fa-file-excel fa-xl"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Upcoming Renewal Report List</h5>
                            </div>
                            <div class="card-body">
                                @if($Count > 0)
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No</th>
                                            <th scope="col">Member Name</th>
                                            <th scope="col">Plan Name</th>
                                            <th scope="col">Start date</th>
                                            <th scope="col">SubscriptionExpiredDate</th>
                                            {{-- <th scope="col">Amount</th> --}}
                                            {{-- <th scope="col">City</th>
                                            <th scope="col">Group Name</th> 
                                            <th scope="col">Category name</th>
                                            <th scope="col">SubCategory name</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>

                                                <td class="text-center">{{ $data->user_id }}</td>
                                                <td class="text-center">{{ $data->plan_name }}</td>
                                                {{-- <td class="text-center">{{ $data->substartdate }}</td>
                                                <td class="text-center">{{ $data->SubscriptionExpiredDate }}</td> --}}
                                                <td class="text-center">{{ \Carbon\Carbon::parse($data->substartdate)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($data->SubscriptionExpiredDate)->format('d-m-Y') }}</td>
                    
                                                {{-- <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($data->renewal_date)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $data->amount }}</td> --}}

                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else 
                                <div class="row">
                                    <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                        <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                            <h1 class="font-white text-center"> No Data Found ! </h1>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $datas->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
            @section('scripts')
                <script>
                    function getEditData(id) {
                        var url = "";
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
                                    var obj = JSON.parse(data);
                                    $("#Editmodel_code").val(obj.model_code);
                                    $("#Editserial_no").val(obj.serial_no);
                                    $("#Editdealer_code").val(obj.dealer_code);
                                    $("#Editinvoice_no").val(obj.invoice_no);
                                    $('#productId').val(id);
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
                    function serialnovalidate() {
                        var SerialNo = $("#serial_no").val();
                        var url = "";
                        $.ajax({
                            url: url,
                            type: 'GET',
                            data: {
                                SerialNo,
                                SerialNo
                            },
                            success: function(data) {
                                console.log(data);
                                var obj = JSON.parse(data);
                                if (data == 1) {
                                    alert('Serial No Already Exist');
                                    $('#serial_no').val('');
                                    $('#serial_no').focus();
                                    return false;
                                }
                            }
                        });
                    }
                </script>
                <script>
                    function editserialnovalidate() {
                        var editSerialNo = $("#Editserial_no").val();
                        var url = "";
                        $.ajax({
                            url: url,
                            type: 'GET',
                            data: {
                                editSerialNo,
                                editSerialNo
                            },
                            success: function(data) {
                                console.log(data);
                                var obj = JSON.parse(data);
                                if (data == 1) {
                                    alert('Serial No Already Exist');
                                    $('#Editserial_no').val('');
                                    $('#Editserial_no').focus();
                                    return false;
                                }
                            }
                        });
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
                    });

                    $(function() {
                        $("#enddatepicker").datepicker({
                            dateFormat: 'd-m-yy',
                            //minDate: 0
                        });
                    });
                </script>

                <script>
                    function exportExcel() {
                        var fromdate = $("#startdatepicker").val();
                        var todate = $("#enddatepicker").val();
                        var first_name = $("#first_name").val();

                        var strURL = "{{ route('reports.export') }}";
                        strURL += "?first_name=" + first_name;

                        window.location.href = strURL;
                    }
                </script>

                <script>
                    $(document).ready(function(){
                        // Add click event listener to the cancel button
                        $('#cancel_search').click(function(){
                            // Reset the value of the input fields to empty
                            $('#startdatepicker').val('');
                            $('#enddatepicker').val('');
                            $('#first_name').val('');

                            // Submit the form to fetch all data
                            $('#form').submit();
                        });
                    });
                </script>
            @endsection
