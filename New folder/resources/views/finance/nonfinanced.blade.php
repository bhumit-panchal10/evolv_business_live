@extends('layouts.app')

@section('title', 'Non Financed List')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Non Financed List</h4>
                            <button class="btn btn-success" type="button" onclick="exportExcel();">
                                <i class="fa-solid fa-file-excel fa-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="form" action="{{ route('finance.NonFinanced') }}">
                                @csrf
                                <div class="row  align-items-center">
                                    <div class="col-md-3  mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter From Date" type="text" class="form-control"
                                                id="startdatepicker" name="fromdate" autocomplete="off"
                                                value="<?= isset($FromDate) ? $FromDate : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3  mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter To Date" type="text" class="form-control"
                                                name="todate" autocomplete="off" id="enddatepicker"
                                                value="<?= isset($ToDate) ? $ToDate : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3  mb-2">
                                        <div class="d-flex align-items-center">
                                            <select class="form-control" name="serviceproviderid" id="serviceproviderid">
                                                <option value="">Select Service Provider</option>
                                                @foreach ($ServiceProvider as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3  mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter Serial Number" type="text" class="form-control"
                                                name="serial_no" autocomplete="off" id="serial_no"
                                                value="<?= isset($SerialNo) ? $SerialNo : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3  mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter Model No" type="text" class="form-control"
                                                name="model_code" autocomplete="off" id="model_code"
                                                value="<?= isset($ModelNo) ? $ModelNo : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3  mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter Dealer Code" type="text" class="form-control"
                                                name="dealer_code" autocomplete="off" id="dealer_code"
                                                value="<?= isset($DealerCode) ? $DealerCode : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3  mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter Invoice No" type="text" class="form-control"
                                                name="invoice_no" autocomplete="off" id="invoice_no"
                                                value="<?= isset($InvoiceNo) ? $InvoiceNo : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="input-group d-flex justify-content-end">
                                            <input type="submit" id="search" class="btn btn-success" name="search"
                                                title="Search" value="Search">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Model Code</th>
                                            <th scope="col">Serial No</th>
                                            <th scope="col">Dealer Code</th>
                                            <th scope="col">Invoice No</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($Product as $product)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $i + $Product->perPage() * ($Product->currentPage() - 1) }}</td>
                                                <td class="text-center">{{ $product->model_code }}</td>
                                                <td class="text-center">{{ $product->serial_no }}</td>
                                                <td class="text-center">{{ $product->dealer_code }}</td>
                                                <td class="text-center">{{ $product->invoice_no }}</td>
                                                <td class="text-center">{{ $product->location }}</td>

                                                <td>
                                                    <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                                        title="Non-Financed To Financed"
                                                        onclick="getEditData(<?= $product->productId ?>)"
                                                        data-bs-target="#showModal">Financed
                                                    </button>
                                                </td>  
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $Product->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Are You Sure Want To Financed??</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form method="POST" action="{{ route('finance.NonFinancedToFinanced') }}"
                                autocomplete="off">
                                @csrf
                                <input type="hidden" name="productId" id="productId" value="">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Service Provider
                                        <select class="form-control" name="serviceproviderid" id="serviceproviderid"
                                            required>
                                            <option selected disabled value="">Select Service Provider</option>
                                            @foreach ($ServiceProvider as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Finance Date
                                        <input placeholder="Enter Finance Date" type="text" class="form-control"
                                            id="financedatepicker" name="fromdate" autocomplete="off" required>
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

            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        function getEditData(id) {
            // alert(id);
            $("#productId").val(id);

        }
    </script>

    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#financedatepicker").datepicker({
                dateFormat: 'd-m-yy',
                //minDate: 0
            });
        });

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
            var serviceproviderid = $("#serviceproviderid").val();
            var serial_no = $("#serial_no").val();
            var strURL = "{{ route('finance.exportToexcelnonfinanced') }}";
            strURL += "?fromdate=" + fromdate + "&todate=" + todate + "&serviceproviderid=" + serviceproviderid +
                "&serial_no=" + serial_no;
            window.location.href = strURL;
        }
    </script>
@endsection
