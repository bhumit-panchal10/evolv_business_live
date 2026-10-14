@extends('layouts.app')

@section('title', 'Report')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Report</h4>
                            <a
                                href="{{ route('report.exportToexcel', [$FromDate ?? 0, $ToDate ?? 0, $ServiceProvider ?? 0, $SerialNo ?? 0]) }}">
                                <i class="fa-solid fa-file-excel fa-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="form" action="{{ route('report.index') }}">
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
                                            <select class="form-control" name="serviceproviderid" id="">
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
                                                name="serial_no" autocomplete="off"
                                                value="<?= isset($SerialNo) ? $SerialNo : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
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
                                            {{--  <th scope="col">Action</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($Product as $product)
                                            <tr>
                                                <td>{{ $i + $Product->perPage() * ($Product->currentPage() - 1) }}</td>
                                                <td>{{ $product->model_code }}</td>
                                                <td>{{ $product->serial_no }}</td>
                                                <td>{{ $product->dealer_code }}</td>
                                                <td>{{ $product->invoice_no }}</td>

                                                {{--  <td style="display: flex">

                                                    <a class="mx-1" title="Edit" href="#"
                                                        onclick="getEditData(<?= $product->productId ?>)"
                                                        data-bs-toggle="modal" data-bs-target="#showModal">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <a class="mx-1" href="#" data-bs-toggle="modal" title="Delete"
                                                        data-bs-target="#deleteRecordModal"
                                                        onclick="deleteData(<?= $product->productId ?>);">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>

                                                </td>  --}}
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

                <!--Edit Modal Start-->
                <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form method="POST" action="{{ route('product.update') }}" autocomplete="off">
                                @csrf
                                <input type="hidden" name="productId" id="productId" value="">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Model Code
                                        <input type="text" class="form-control" name="model_code" id="Editmodel_code"
                                            placeholder="Enter Model Code" maxlength="100" autocomplete="off" required>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Serial No
                                        <input type="text" class="form-control" id="Editserial_no" name="serial_no"
                                            onblur="editserialnovalidate();"
                                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                            placeholder="Enter Serial No" maxlength="100" autocomplete="off" required>
                                        @error('serial_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Dealer Code
                                        <input type="text" class="form-control" name="dealer_code"
                                            id="Editdealer_code" placeholder="Enter Dealer Code" maxlength="100"
                                            autocomplete="off" required>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Invoice No
                                        <input type="text" class="form-control" name="invoice_no" id="Editinvoice_no"
                                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                            placeholder="Enter Invoice No" maxlength="100" autocomplete="off" required>
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



    <!--Delete Modal -->
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
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                            Yes,
                            Delete It!
                        </a>
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <form id="user-delete-form" method="POST"
                            action="{{ route('product.delete', $product->id ?? '') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="productId" id="deleteid" value="">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Modal -->

@endsection

@section('scripts')

    <script>
        function getEditData(id) {
            var url = "{{ route('product.edit', ':id') }}";
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
            var url = "{{ route('product.checkserialno') }}";
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
            var url = "{{ route('product.editcheckserialno') }}";
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
@endsection
