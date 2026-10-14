@extends('layouts.app')
@section('title', 'Report Detail List')
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
                                    <a class="nav-link {{ request()->routeIs('reports.Member_reports_detail') ? 'active' : '' }}"
                                        href="{{ route('reports.Member_reports_detail', $getmemberid->id) }}">
                                        <i class="fas fa-clock"></i> BusinessGiven
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->routeIs('reports.reports_recived_detail') ? 'active' : '' }}"
                                        href="{{ route('reports.reports_recived_detail', $getmemberid->id) }}">
                                        <i class="fas fa-check-circle"></i> BusinessReceived
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->routeIs('reports.refbusiness_given') ? 'active' : '' }}"
                                        href="{{ route('reports.refbusiness_given', $getmemberid->id) }}">
                                        <i class="fas fa-check-circle"></i> RefBusinessGiven
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->routeIs('reports.refbusiness_received') ? 'active' : '' }}"
                                        href="{{ route('reports.refbusiness_received', $getmemberid->id) }}">
                                        <i class="fas fa-check-circle"></i> RefBusinessReceived
                                    </a>
                                </li>
                            </ul>
                        </div><!-- end card-body -->
                    </div>
                </div>
                {{-- Tab End  --}}

                {{-- NEW --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">RefBusiness Received</h5>
                            </div>
                            <div class="card-body">
                                @if ($Count > 0)

                                    <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                        <thead>
                                            
                                            <tr>
                                                <th scope="col">Sr No</th>
                                                <th scope="col">Business From</th>
                                                <th scope="col">Business To</th>
                                                <th scope="col">Business Amount</th>
                                                <th scope="col">Business Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                              $RefBusinessReceived=0;
                                            ?>

                                            @foreach ($datas as $data)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                    <td class="text-center">
                                                        {{ isset($data->business_from) ? $data->business_from : '-' }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ isset($data->business_to) ? $data->business_to : '-' }}</td>
                                                    <td class="text-center">
                                                        {{ isset($data->Business_amount) ? $data->Business_amount : '-' }}
                                                    </td>

                                                    <td class="text-center">
                                                        {{ $data->business_Date ? \Carbon\Carbon::parse($data->business_Date)->format('d-m-Y') : '-' }}
                                                    </td>
                                                </tr>
                                                    @php
                                                        $i++;
                                                        $RefBusinessReceived += $data->Business_amount ?? 0;

                                                    @endphp
      
                                            @endforeach
                                        </tbody>
                                        <tr class="text-center">
                                    <td colspan=3 text-align="right">&nbsp; Total</td>
                                        <td>{{$RefBusinessReceived}}</td>
                                    </tr>

                                    </table>

                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $datas->links() }}
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
                {{-- NEW --}}


            </div>

        </div>
    </div>
    </div>



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
            strURL += "/" + fromdate + "/" + todate;

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

    <!-- search new code -->
    <script>
        $(document).ready(function() {
            // Add click event listener to the cancel button
            $('#cancel_search').click(function() {
                // Reset the value of the category_id select element to empty
                $('#startdatepicker').val('');
                $('#enddatepicker').val('');
                $('#business_type').val('');
                $('#given_by').val('');
                $('#form').submit();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#Editbusiness_Date").datepicker({
                dateFormat: "yy-mm-dd",
                //minDate: 0
            });
        });
    </script>
@endsection
