@extends('layouts.app')
@section('title', 'Business List')
@section('content')
<?php $session = auth()->user(); ?>

    <div class="main-content ">
        <div class="page-content">
            <div class="container-fluid">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="mb-5" style="color:red">{{ $error }}</li>
                    @endforeach
                @endif

                {{-- Alert Messages --}}
                @include('common.alert')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"> Add Business</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <!-- <form action="{{ route('MemberBusiness.create') }}" method="post"
                                        enctype="multipart/form-data"> -->
                                        <form id="businessForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-3 mb-3">
                                            <div class="col-lg-4 col-md-6">
                                                <label for="business_from_id"><span style="color:red;">*</span>Business
                                                    Type</label>
                                                <select class="form-control" name="business_type" id="business_type"
                                                    value="{{ old('business_type') }}" required>
                                                    <option value="1">Direct</option>
                                                    <option value="2">Reference</option>
                                                </select>
                                            </div>


                                            {{-- <div class="col-lg-4 col-md-6">
                                                <label for="business_from_id"><span style="color:red;">*</span>Given By</label>
                                                <select class="form-control" name="business_from" required>
                                                    <option value="" disabled selected>Select Given By</option>
                                                    @foreach ($Data as $data)
                                                        <option value="{{ $data->id }}">{{ $data->first_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>         --}}                                          
                                           
                                            {{-- <div class="col-lg-4 col-md-6">
                                                <label for="business_to_id"><span style="color:red;">*</span>Given To</label>
                                                <select class="form-control" name="business_to" required>
                                                    <option value="" disabled selected>Select Given By</option>
                                                    @foreach ($Data as $data)
                                                        <option value="{{ $data->id }}">{{ $data->first_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <!-- this same user name not select code start -->
                                            <div class="col-lg-4 col-md-6">
                                                <label for="business_to"><span style="color:red;">*</span>Given To</label>
                                                <select class="form-control" data-choices name="business_to" id="choices-single-default">
                                                    <option value="" disabled selected>Select Given To</option>
                                                    @foreach ($Data as $data)
                                                        @if ($data->id !== $session->id) 
                                                            <option value="{{ $data->id }}">{{ $data->first_name }} - ({{$data->mobile_number}})</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                          
                                              <!-- this same user name not select code end -->
                                            <div class="col-lg-4 col-md-6">
                                            <label for="Business_amount"><span style="color:red;">*</span>Amount</label>                              
                                                <input type="number" class="form-control" name="Business_amount"
                                                    id="Business_amount" placeholder="Enter Amount"
                                                    value="{{ old('Business_amount') }}" required>
                                            </div>

                                            <!-- <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span> Business date
                                                <input type="date" class="form-control" name="business_Date"
                                                    id="business_Date" placeholder="Enter business Date" required>
                                            </div> -->
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span> Business date
                                                <input type="text" class="form-control" name="business_Date"  id="startdatepicker" placeholder="Enter business Date" required>
                                            </div>


                                            <div class="text-center">
                                                <button type="button" class="btn btn-success btn-user"
                                                    style="width: 85px; height: 40px;" onclick="submitForm()">Submit</button>
                                                <button type="button" class="btn btn-danger btn-user"
                                                    style="width: 85px;" onclick="cancelForm()">Cancel</button>
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>
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
            //alert(id);
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
                        //console.log(data);
                        var obj = JSON.parse(data);
                        $("#Editname").val(obj.name);
                        $('#event_id').val(id);
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
        $(document).ready(function() {
            $("#priceField").hide();
            $("#ispaid").change(function() {
                if ($(this).val() === "Yes") {
                    $("#priceField").show();
                } else {
                    $("#priceField").hide();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#setnumber").hide();
            $("#limitedset").change(function() {
                if ($(this).val() === "Yes") {
                    $("#setnumber").show();
                } else {
                    $("#setnumber").hide();
                }
            });
        });
    </script>
    <script>
     function cancelForm() {
         window.location.reload(); 
     }
 </script>

 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {
        $("#startdatepicker").datepicker({
            dateFormat: "yy-mm-dd",
            //minDate: 0
        });

        $("#enddatepicker").datepicker({
            dateFormat: "yy-mm-dd",
            //minDate: 0
        });
    });
</script>

<script>

function submitForm() {
    if (confirm("Are you sure you want to submit the business?")) {
        var formData = new FormData(document.getElementById('businessForm'));
        $.ajax({
            url: "{{ route('MemberBusiness.create') }}",  
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert('Business Created Successfully.');
                window.location.href = "{{ route('MemberBusiness.index') }}"; 
            },
            error: function(xhr) {
                alert('An error occurred while submitting the form.');
                console.log(xhr.responseText); 
            }
        });
    }
}


</script>

@endsection
