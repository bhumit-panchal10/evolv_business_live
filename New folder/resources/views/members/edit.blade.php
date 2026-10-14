@extends('layouts.app')
@section('title', 'Members List')
@section('content')

    <div class="main-content">
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
                                <h5 class="card-title mb-0">update Members</h5>
                            </div> 

                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('members.update', $data->id)}}" method="post"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="id" id="getid" value="{{$data['id']}}">
                                        @csrf
                                        <div class="row gy-2" style="align-items: end;">
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;"></span> Brand Name
                                                <input type="text" class="form-control" name="companyname"
                                                    id="companyname" placeholder="Enter Brand Name" maxlength="100"
                                                    autocomplete="off" value ="{{ $data->companyname }}">
                                            </div>
                                             <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Branch Establish Year                        
                                                <span style="color:red;" class="error-message">{{ $errors->first('brand_establish_year') }}</span> 
                                                <input type="text" class="form-control" name="brand_establish_year" id="brand_establish_year"
                                                    placeholder="Enter Brand Establish Year" value="{{old('brand_establish_year')}}"  onKeyPress="if(this.value.length==6) return false;" required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                GST Number
                                                <input type="text" class="form-control" name="gstnumber"
                                                    value="{{ $data['gstnumber'] }}" id="gstnumber"
                                                    placeholder="Enter GST Number">
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span> Member Name
                                                <input type="text" class="form-control" name="first_name"
                                                    id="first_name" placeholder="Enter Member Name" maxlength="100"
                                                    autocomplete="off" value ="{{$data['user_id']}}">
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span> Phone Number
                                                <input type="text" class="form-control" name="phonenumber"
                                                    id="phonenumber" placeholder="Enter Phone Number"
                                                    value ="{{ $data['phonenumber'] }}" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span> Email
                                                <input type="email" class="form-control" name="email" id="email"
                                                    placeholder="Enter Email" value ="{{ $data['email'] }}" required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                 <span style="color: red;">*</span>Date of Birth
                                                <span style="color:red;" class="error-message">{{ $errors->first('date_of_birth') }}</span> 
                                                <input type="date" class="form-control" name="date_of_birth"
                                                    id="date_of_birth" placeholder="Enter Date Of Birth"  value="{{old('date_of_birth')}}" required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span> Residential Address
                                                <input type="text" class="form-control" name="address" id="address"
                                                    placeholder="Enter Address" value ="{{ $data['address'] }}" required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <label for="city_id"><span style="color:red;">*</span> City Name</label>
                                                <select class="form-control" name="city_id" id="city_id" required
                                                    onchange="updateCityGroups()">
                                                    <option value="" selected>Select City Name</option>
                                                    @foreach ($cities as $city)
                                                        <option
                                                            value="{{ $city->id }}"{{ $data->city_id == $city->id ? 'selected' : '' }}>
                                                            {{ $city->city_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span> Pincode
                                                <input type="text" class="form-control" name="pincode" id="pincode"
                                                    placeholder="Enter Pincode" value ="{{ $data['pincode'] }}" onKeyPress="if(this.value.length==6) return false;" required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <label for="citygroup_id"><span style="color:red;">*</span> City Group
                                                    Name</label>
                                                <select class="form-control" name="citygroup_id" id="citygroup_id" required>
                                                    @foreach ($cityGroups as $cityGroup)
                                                        <option
                                                            value="{{ $cityGroup->id }}"{{ $data->citygroup_id == $cityGroup->id ? 'selected' : '' }}>
                                                            {{ $cityGroup->group_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <label for="category_id"><span style="color:red;">*</span> Category
                                                    Name</label>
                                                <select class="form-control" name="category_id" id="category_id" required
                                                    onchange="updatesubcategories()">
                                                    <option value="" selected>Select category Name</option>
                                                    @foreach ($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}"{{ $data->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            
                                            <div class="col-lg-4 col-md-6">
                                                <label for="plan_id"><span style="color:red;">*</span> Plan Name</label>
                                                <select class="form-control" name="plan_id" id="plan_id">
                                                    <option value="" selected>Select Plan Name</option>
                                                    @foreach ($plans as $plan)
                                                        <option
                                                            value="{{ $plan->id }}"{{ $data->plan_id == $plan->id ? 'selected' : '' }}>
                                                            {{ $plan->plan_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span> Joining date
                                                <input type="text" class="form-control" name="renewal_date"
                                                    id="renewal_date" placeholder="Enter Membership date"
                                                    value ="{{ $data['renewal_date'] }}" required>
                                            </div>
                                          
                                            <!-- this field old end  -->
                                            <!-- this field new start  -->
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;"></span> PaymentRefNo
                                                <input type="text" class="form-control" name="PaymentRefNo" id="PaymentRefNo" placeholder="Enter PaymentRefNo" value="{{ $data['paymentrefNo'] }}" oninput="this.value = this.value.replace(/[^0-9_()-]/g, '');">
                                            </div>
                                            <!-- this field new start  -->
                                           
                                           
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-success btn-user style="width:
                                                    100px; height: 40px;"">Submit</button>
                                                    <button type="button" class="btn btn-danger btn-user float-right" onclick="cancelForm()">Cancel</button>
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
                        $("#Editaddress").val(obj.address);
                        $("#Editcity").val(obj.city);
                        $("#Editpincode").val(obj.pincode);
                        $("#Editgstnumber").val(obj.gstnumber);
                        $("#Editgstbudgecount").val(obj.budgecount);
                        $('#getid').val(obj.id);
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

<script>
        function cancelForm() {
            window.location.reload(); 
        }
    </script>
    
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {
        $("#renewal_date").datepicker({
            dateFormat: "yy-mm-dd",
            //minDate: 0
        });      
    });
</script>
@endsection

