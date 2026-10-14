@extends('layouts.app')
@section('title', 'Products-Service Add')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
          
            <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                
                {{-- Alert Messages --}}
                @include('common.alert')

               
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Add Product-Service</h5>
                        </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('Products_service.Store') }}" method="post" enctype="multipart/form-data">
                                       
                                        @csrf
                                        <input type="hidden" name ="memberid" value="{{$id}}">
                                        <div class="row gy-3 mb-3">
                                            <div class="col-lg-4 col-md-6">                                              
                                                <span style="color:red;" class="error-message">{{ $errors->first('product_name') }}*</span>Product Name 
                                                <input type="text" class="form-control" name="product_name"
                                                    id="productname" placeholder="Enter Product Name" maxlength="100"
                                                    autocomplete="off" required>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                               <span style="color:red;" class="error-message">{{ $errors->first('photo') }}</span>Photo
                                                <input type="file" class="form-control" name="photo" id="photo"
                                                    placeholder="Enter Image">
                                                    <p class="help-block">Please upload a photo for your profile.</p>
                                            </div>
                                        </div>
                                        <div class="row gy-3">                                          
                                        <div class="col-lg-4 col-md-6">
                                            <span style="color:red;"></span>Price Type 
                                            <select class="form-control" name="price_type" id="price_type">
                                               <option value="">Select Price Type</option>
                                                <option value="fixed">Fixed</option>
                                                <option value="ranged">Ranged</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-4 col-md-6" id="fixed_price_input" style="display: none;">
                                            <span style="color:red;"></span> Price
                                            <input type="number" class="form-control" name="fixed_price" id="fixed_price" placeholder="Enter price" >
                                        </div>

                                                <div class="col-lg-4 col-md-6" id="ranged_price_input" style="display: none;">
                                                <span style="color:red;"></span> Price Range
                                                <div class="row gy-3">
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="min_price" id="min_price" placeholder="Min price" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="max_price" id="max_price" placeholder="Max price">
                                                    </div>
                                                </div>
                                            </div>


                                              <div>
                                                 <!-- new code 14-05-2024 -->
                                             <div>
                                                    <label for="multiline_description">
                                                        <span style="color:red;"></span>Search Keyword
                                                    </label>
                                                    <textarea class="form-control" name="multiline_description" id="" placeholder="Enter Search Keyword with coma sepreted" rows="4" maxlength="500" autocomplete="off"></textarea>
                                                </div>
                                                 <!-- new code 14-05-2024 -->
                                                <div>
                                                    <label for="description">
                                                        <span style="color:red;">*</span>Description
                                                    </label>
                                                    <textarea class="form-control" name="description" id="" placeholder="Enter Description" rows="4" maxlength="500" autocomplete="off"></textarea>
                                                </div>
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
            var url = "{{ route('members.edit', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        // alert($data);
                        var obj = JSON.parse(data);
                        $("#Editname").val(obj.companyname);
                        $("#Editphonenumber").val(obj.phonenumber);
                        $("#Editemail").val(obj.email);
                        $("#Editpassword").val(obj.password);
                        $("#Editaddress").val(obj.address);
                        $("#Editcity").val(obj.city);
                        $("#Editpincode").val(obj.pincode);
                        $("#Editgstnumber").val(obj.gstnumber);
                        $("#Editgstbudgecount").val(obj.budgecount);
                        $('#getid').val(id);
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
        function chkname() {
            var name = $('#companyname').val();
            var url = "{{ route('members.checkserviceprovider') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    name,
                    name
                },
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (data == 1) {

                        alert('Members Already Exist');
                        $('#companyname').val('');
                        $('#companyname').focus();
                        return false;

                    }
                }
            });
        }
    </script>
    <script>
        function editchkname() {
            var name = $('#Editname').val();
            var url = "{{ route('members.editcheckserviceprovider') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    name,
                    name
                },
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (data == 1) {

                        alert('Members Already Exist');
                        $('#Editname').val('');
                        $('#Editname').focus();
                        return false;

                    }
                }
            });
        }
    </script>

    {{-- city based display group --}}
    <script>
        function updateCityGroups() {
            var city_id = $("#city_id").val();
            var url = "{{ route('members.cityid', ':city_id') }}";
            url = url.replace(":city_id", city_id);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    city_id: city_id,
                },
                success: function(data) {
                    $("#citygroup_id").html('');
                    $("#citygroup_id").append(data);
                }
            });
        }
    </script>


    <script>
        function updatesubcategories() {
            var categories_id = $("#category_id").val();
            var url = "{{ route('members.categoryid', ':category_id') }}";
            url = url.replace(":category_id", categories_id);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    category_id: categories_id,
                },
                success: function(data) {
                    $("#subcategories_id").html('');
                    $("#subcategories_id").append(data);
                }
            });
        }
    </script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        var priceTypeSelect = document.getElementById("price_type");
        var fixedPriceInput = document.getElementById("fixed_price_input");
        var rangedPriceInput = document.getElementById("ranged_price_input");

        priceTypeSelect.addEventListener("change", function () {
            if (priceTypeSelect.value === "fixed") {
                fixedPriceInput.style.display = "block";
                rangedPriceInput.style.display = "none";
            } else if (priceTypeSelect.value === "ranged") {
                fixedPriceInput.style.display = "none";
                rangedPriceInput.style.display = "block";
            }
        });
    });
</script> -->

<script>
        document.addEventListener("DOMContentLoaded", function() {
            var priceTypeSelect = document.getElementById("price_type");
            var fixedPriceInput = document.getElementById("fixed_price_input");
            var rangedPriceInput = document.getElementById("ranged_price_input");

            // Set initial display state based on the default value of Price Type
            if (priceTypeSelect.value === "fixed") {
                fixedPriceInput.style.display = "block";
                rangedPriceInput.style.display = "none";
            } else if (priceTypeSelect.value === "ranged") {
                fixedPriceInput.style.display = "none";
                rangedPriceInput.style.display = "block";
            }

            priceTypeSelect.addEventListener("change", function() {
                if (priceTypeSelect.value === "fixed") {
                    fixedPriceInput.style.display = "block";
                    rangedPriceInput.style.display = "none";
                } else if (priceTypeSelect.value === "ranged") {
                    fixedPriceInput.style.display = "none";
                    rangedPriceInput.style.display = "block";
                }
            });
        });
    </script>
     

     <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
    <script type="text/javascript">
        // Initialize NicEdit for specific textareas by their IDs
        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel: true}).panelInstance('description'); // For description textarea
        });
    </script>

<script>
     function cancelForm() {
         window.location.reload(); 
     }
 </script>
@endsection
