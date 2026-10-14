@extends('layouts.app')
@section('title', 'Business List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="mb-5" style="color:red">{{ $error }}</li>
                    @endforeach
                @endif -->

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
                                    <form onsubmit="return validateSelections();" action="{{ route('Business.create') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-3 mb-3">
                                            <div class="col-lg-4 col-md-6"> Business Type               
                                              <span style="color:red;" class="error-message">{{ $errors->first('business_type') }}*</span>
                                                <select class="form-control" name="business_type" id="business_type"
                                                    value="{{ old('business_type') }}" required>
                                                    <option value="1">Direct</option>
                                                    <option value="2">Reference</option>
                                                </select>
                                            </div>


        
                                            <div class="col-lg-4 col-md-6">
                                            <span style="color: red;">*</span>Given By                                              
                                                <span style="color:red;" class="error-message">{{ $errors->first('business_from') }}</span>
                                                <select class="form-control" data-choices name="business_from"
                                                     id="choices-single-default-given-by">
                                                    <option value="" disabled selected>Select Given By</option>
                                                    @foreach ($Data as $data)
                                                        <option value="{{ $data->id }}">{{ $data->first_name }} - ({{$data->mobile_number}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                           
                                            <div class="col-lg-4 col-md-6">
                                            <span style="color: red;">*</span>Given To                                              
                                                <span style="color:red;" class="error-message">{{ $errors->first('business_to') }}</span>
                                                <select class="form-control" data-choices name="business_to"
                                                id="choices-single-default-given-to">
                                                    <option value="" disabled selected>Select Given To</option>
                                                    @foreach ($Data as $data)
                                                        <option value="{{ $data->id }}">{{ $data->first_name }} - ({{$data->mobile_number}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                            <span style="color: red;">*</span>Amount
                                            <span style="color:red;" class="error-message">{{ $errors->first('Business_amount') }}</span>
                                                <input type="number" class="form-control" name="Business_amount"
                                                    id="Business_amount" placeholder="Enter Business Amount"
                                                    value="{{ old('Business_amount') }}" required>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                            <span style="color: red;">*</span>Business date
                                            <span style="color:red;" class="error-message">{{ $errors->first('business_Date') }}</span>
                                                <input type="text" class="form-control" name="business_Date"
                                                    id="business_Date" placeholder="Enter Business Date" required>
                                            </div>


                                            <div class="text-center">
                                                <button type="submit" class="btn btn-success btn-user"
                                                    style="width:
                                                    81px; height: 36px;">Submit</button>
                                                <button type="button" class="btn btn-danger btn-user" style="width:
                                                    81px; height: 34px;" onclick="cancelForm()">Cancel</button>
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
    // Function to check if the same person is selected for both "Given By" and "Given To"
    function validateSelections() {
        var givenBy = document.getElementById('choices-single-default-given-by').value;
        var givenTo = document.getElementById('choices-single-default-given-to').value;

        if (givenBy === givenTo) {
            alert("You cannot select the same person for both 'Given By' and 'Given To'. Please select different persons.");
            return false;
        }

        return true;
    }
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
        $("#business_Date").datepicker({
            dateFormat: "yy-mm-dd",
            //minDate: 0
        });      
    });
</script>

@endsection
