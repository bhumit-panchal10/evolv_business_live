@extends('layouts.app')
@section('title', 'Members List')
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
                                <h5 class="card-title mb-0">Add Members</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('members.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-3 mb-3">
                                            {{-- <div class="col-lg-4 col-md-6">Brand Name
                                                <span style="color:red;" class="error-message">{{ $errors->first('companyname') }}*</span> 
                                                <input type="text" class="form-control" name="companyname"
                                                    id="companyname" placeholder="Enter Brand Name" maxlength="100"
                                                    autocomplete="off" value="{{old('companyname')}}" required>
                                            </div> --}}
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color: red;"></span> Brand Name
                                                <span style="color: red;" class="error-message">{{ $errors->first('companyname') }}</span> 
                                                <input type="text" class="form-control" name="companyname" id="companyname" placeholder="Enter Brand Name" maxlength="100" autocomplete="off" value="{{ old('companyname') }}">
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Branch Establish Year                        
                                                <span style="color:red;" class="error-message">{{ $errors->first('brand_establish_year') }}</span> 
                                                <input type="text" class="form-control" name="brand_establish_year" id="brand_establish_year"
                                                    placeholder="Enter Brand Establish Year" value="{{old('brand_establish_year')}}"  onKeyPress="if(this.value.length==6) return false;" required>
                                            </div>

                                            
                                            <div class="col-lg-4 col-md-6">
                                                GST Number
                                                <input type="text" class="form-control" name="gstnumber" id="gstnumber"
                                                    placeholder="Enter GST Number" value="{{old('gstnumber')}}" >
                                            </div>
                                        </div>
                                        <div class="row gy-3" style="align-items: end;">
                                          

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Member Name                                        
                                                <span style="color:red;" class="error-message">{{ $errors->first('first_name') }}</span> 
                                                <input type="text" class="form-control" name="first_name" id="first_name"
                                                    placeholder="Enter Member Name" maxlength="100" autocomplete="off" value="{{old('first_name')}}"
                                                    required>
                                            </div>

                                            <div class="col-lg-4 col-md-6"> 
                                                 <span style="color: red;">*</span>Phone Number                                    
                                                <span style="color:red;" class="error-message">{{ $errors->first('phonenumber') }}</span> 
                                                <input type="text" class="form-control" name="phonenumber"
                                                    id="phonenumber" placeholder="Enter Phone Number" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" maxlength="10" minlength="10" value="{{old('phonenumber')}}" required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Email
                                                <span style="color:red;" class="error-message">{{ $errors->first('email') }}</span> 
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{old('email')}}" required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                 <span style="color: red;">*</span>Date of Birth
                                                <span style="color:red;" class="error-message">{{ $errors->first('date_of_birth') }}</span> 
                                                <input type="date" class="form-control" name="date_of_birth"
                                                    id="date_of_birth" placeholder="Enter Date Of Birth"  value="{{old('date_of_birth')}}" required>
                                            </div>


                                            <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Residential Address 
                                            <span style="color:red;" class="error-message">{{ $errors->first('address') }}</span> 
                                                <input type="text" class="form-control" name="address" id="address"
                                                    placeholder="Enter Address" value="{{old('address')}}"  required>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <label for="city_id"><span style="color:red;">*</span> City Name</label>
                                                <select class="form-control" name="city_id" id="city_id" required onchange="updateCityGroups()">
                                                    <option value="" selected>Select City Name</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                            {{ $city->city_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Pincode                        
                                                <span style="color:red;" class="error-message">{{ $errors->first('pincode') }}</span> 
                                                <input type="text" class="form-control" name="pincode" id="pincode"
                                                    placeholder="Enter Pincode" value="{{old('pincode')}}"  onKeyPress="if(this.value.length==6) return false;" required>
                                            </div>

                                            <div class="row gy-2 mb-3">

                                           
                                            <div class="col-lg-4 col-md-6">
                                                <label for="citygroup_id"><span style="color:red;">*</span> City Group Name</label>
                                                <select class="form-control" name="citygroup_id" id="citygroup_id" required>
                                                    <option value="">Select City Group Name</option>
                                                    @foreach ($cityGroups as $group)
                                                        <option value="{{ $group->id }}" {{ old('citygroup_id') == $group->id ? 'selected' : '' }}>
                                                            {{ $group->group_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('citygroup_id')
                                                    <span style="color: red;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <label for="category_id"><span style="color:red;">*</span> Category Name</label>
                                                <select class="form-control" name="category_id" id="category_id" required onchange="updatesubcategories()">
                                                    <option value="" {{ old('category_id') == '' ? 'selected' : '' }}>Select category Name</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            </div>                                          
                                            <div class="col-lg-4 col-md-6">
                                                <label for="plan_id"><span style="color:red;">*</span> Plan Name</label>
                                                <select class="form-control" name="plan_id" id="plan_id">
                                                    <option value="" selected>Select Plan Name</option>
                                                    @foreach ($plans as $plan)
                                                       
                                                        <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                                        {{ $plan->plan_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                 <span style="color: red;">*</span>Joining Date
                                                <span style="color:red;" class="error-message">{{ $errors->first('renewal_date') }}</span> 
                                                <input type="text" class="form-control" name="renewal_date"
                                                    id="renewal_date" placeholder="Enter Membership Date"  value="{{old('renewal_date')}}" required>
                                            </div>
                                           

                                            <!-- new payment ref number start -->
                                            <div class="col-lg-4 col-md-6">PaymentRefNo                                        
                                                <span style="color:red;" class="error-message">{{ $errors->first('PaymentRefNo') }}</span> 
                                                <input type="text" class="form-control" name="PaymentRefNo" id="PaymentRefNo" placeholder="Enter PaymentRefNo" value="{{ old('PaymentRefNo') }}" oninput="this.value = this.value.replace(/[^0-9_()-]/g, '');">
                                            </div>
                                            <!-- new payment ref number End -->

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Password                                                
                                                <span style="color:red;" class="error-message">{{ $errors->first('password') }}</span> 
                                                <input type="password" class="form-control" name="password" id="password"
                                                    placeholder="Enter Password" value="{{old('password')}}" required>
                                            </div>
                                            {{-- old code start --}}
                                            {{-- <div class="col-lg-4 col-md-6">Book Your Podcast                                                
                                                <span style="color:red;" class="error-message">{{ $errors->first('Book_Your_Podcast ') }}*</span> 
                                                <input type="text" class="form-control" name="Book_Your_Podcast" id="Book_Your_Podcast"
                                                    placeholder="Enter Book Your Podcast" value="{{old('Book_Your_Podcast')}}" required>
                                            </div>
                                            <div class="col-lg-4 col-md-6">Book Your Member of the week                                               
                                                <span style="color:red;" class="error-message">{{ $errors->first('Book_Your_Member_of_the_week  ') }}*</span> 
                                                <input type="text" class="form-control" name="Book_Your_Member_of_the_week" id="Book_Your_Member_of_the_week"
                                                    placeholder="Enter Book Your Member of the week" value="{{old('Book_Your_Member_of_the_week')}}" required>
                                            </div> --}}
                                            {{-- old code end --}}

                                           
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var inputField = document.getElementById("Book_Your_Podcast");
        
        // Function to check if the selected date is Tuesday or Friday
        function isTuesdayOrFriday(date) {
            var day = new Date(date).getDay();
            return (day === 2 || day === 5); // Tuesday is 2, Friday is 5
        }

        // Event listener to restrict selection to Tuesdays and Fridays
        inputField.addEventListener("input", function() {
            if (!isTuesdayOrFriday(this.value)) {
                alert("Please select a Tuesday or Friday.");
                this.value = ""; // Clear the input field
            }
        });
    });
</script>

<script>
    // Get the input field
    var input = document.getElementById("Book_Your_Member_of_the_week");

    // Disable dates that are not Monday
    input.addEventListener("input", function() {
        var selectedDate = new Date(this.value);
        var dayOfWeek = selectedDate.getDay(); // Sunday - Saturday : 0 - 6
        if (dayOfWeek !== 1) { // Monday is represented by 1
            this.value = ''; // Reset the value if not Monday
            alert('Please select only Monday.');
        }
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
        $("#renewal_date").datepicker({
            dateFormat: "yy-mm-dd",
            //minDate: 0
        });      
    });
</script>

@endsection
