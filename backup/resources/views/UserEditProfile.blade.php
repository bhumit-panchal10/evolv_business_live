
@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid mt-4">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="position-relative mx-n4 mt-n4">
                    <div class="profile-wid-bg profile-setting-img">
                        <img src="https://groath.in/assets/images/auth-one-bg.jpg" class="profile-wid-img" alt="">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    @if(isset($member->profile_photo ))  
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <img src="{{ asset('profile_photo') . '/' . $member->profile_photo }}"
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                            alt="user-profile-image">
                                    </div>
                                      @else 
                                      <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <img src="https://groath.in/assets/images/users/undraw_profile.webp" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                     </div>
                                      @endif      
                                    
                                    <h5 class="mb-1">{{ auth()->user()->full_name }}</h5>
                                    <?php
                                    $session = auth()->user()->id;
                                    $role = App\Models\User::select('users.id', 'roles.name')
                                        ->where('users.id', $session)
                                        ->join('roles', 'users.role_id', '=', 'roles.id')
                                        ->first();
                                    ?>
                                    <p class="text-muted mb-0">
                                        {{ $role->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                            role="tab">
                                            <i class="fas fa-home"></i> Personal Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                            <i class="far fa-user"></i> Change Password
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <form action="{{ route('profile.Userupdate') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>First Name
                                                        <input type="text"
                                                            class="form-control @error('first_name') is-invalid @enderror"
                                                            name="first_name" id="firstnameInput"
                                                            placeholder="Enter Your FirstName" maxlength="100"
                                                            value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name }}"
                                                            autocomplete="off" required>

                                                        @error('first_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;"></span>Last Name
                                                        <input type="text"
                                                            class="form-control @error('last_name') is-invalid @enderror"
                                                            id="lastnameInput" name="last_name"
                                                            placeholder="Enter Your LastName" maxlength="100"
                                                            value="{{ old('last_name') ? old('last_name') : auth()->user()->last_name }}"
                                                            autocomplete="off">

                                                        @error('last_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Email
                                                        <input type="email" name="email"
                                                            class="form-control  @error('email') is-invalid @enderror"
                                                            maxlength="100" id="emailInput" placeholder="Enter Your Email"
                                                            value="{{ old('email') ? old('email') : auth()->user()->email }}"
                                                            autocomplete="off" readonly>

                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Phone
                                                        <input type="text"
                                                            class="form-control @error('mobile_number') is-invalid @enderror"
                                                            id="phonenumberInput" placeholder="Enter your phone number"
                                                            name="mobile_number"
                                                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                            minlength="10" maxlength="10"
                                                            value="{{ old('mobile_number') ? old('mobile_number') : auth()->user()->mobile_number }}"
                                                            autocomplete="off" required>

                                                        @error('mobile_number')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Address
                                                        <input type="text" name="address"
                                                            class="form-control  @error('address') is-invalid @enderror"
                                                            maxlength="100" id="address" placeholder="Enter Your Address"
                                                            value="{{ old('address') ? old('address') : $member->address }}"
                                                            autocomplete="off" required>

                                                        @error('address')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- new add -->
                                                 <!-- Date of Birth -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Date of Birth
                                                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                                                            id="dateOfBirthInput" placeholder="Select Your Date of Birth"
                                                            value="{{ old('date_of_birth') ? old('date_of_birth') : $member->date_of_birth }}"
                                                            autocomplete="off" required>

                                                        @error('date_of_birth')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Work Anniversary Date -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Work Anniversary Date
                                                        <input type="date" name="work_anniversary_date" class="form-control @error('work_anniversary_date') is-invalid @enderror"
                                                            id="workAnniversaryDateInput" placeholder="Select Your Work Anniversary Date"
                                                            value="{{ old('work_anniversary_date') ? old('work_anniversary_date') : $member->work_anniversary_date }}"
                                                            autocomplete="off" required>

                                                        @error('work_anniversary_date')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- new add -->
                                                                                            
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                    <span style="color:red;">*</span>Profile pic</label>
                                                    <input class="form-control" type="file" name="profile_photo" id="photovalidate"
                                                    value="{{ old('profile_photo')}}">
                                                    <input type="hidden" name="hiddenPhoto_profile_photo" class="form-control"
                                                            value="{{ old('profile_photo') ? old('profile_photo') : $member->profile_photo }}" id="hiddenPhoto_profile_photo">
                                                        <div id="viewimg">
                                                            <img src="{{ asset('profile_photo') . '/' . $member->profile_photo }}" alt=""
                                                                height="70" width="70">
                                                        </div>
                                                        @error('profile_photo')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Brand Name
                                                        <input type="text" name="Brand_name"
                                                            class="form-control  @error('Brand_name') is-invalid @enderror"
                                                            maxlength="150" id="Brand_name" placeholder="Enter Your Brand Name"
                                                            value="{{ old('Brand_name') ? old('Brand_name') : $member->companyname }}"
                                                            autocomplete="off" required >
                                                        @error('Brand_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;"></span>Company Name
                                                        <input type="text" name="companyname"
                                                            class="form-control  @error('companyname') is-invalid @enderror"
                                                            maxlength="150" id="companyname" placeholder="Enter Your Company Name"
                                                            value="{{ old('companyname') ? old('companyname') : $member->Brand_name }}"
                                                            autocomplete="off" >
                                                        @error('companyname')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                    <span style="color:red;"></span>Company logo</label>
                                                    <input class="form-control" type="file" name="Company_logo" id="Company_logo"
                                                        value="{{ old('Company_logo') }}" >
                                                        <input type="hidden" name="hiddenPhoto_Company_logo" class="form-control"
                                                            value="{{ old('Company_logo') ? old('Company_logo') : $member->Company_logo }}" id="hiddenPhoto_Company_logo">
                                                        <div id="viewimg">
                                                            <img src="{{ asset('Company_logo') . '/' . $member->Company_logo }}" alt=""
                                                                height="70" width="70">
                                                        </div>
                                                        @error('Company_logo')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- Facebook start -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;"></span>Facebook link
                                                        <input type="text" name="facebook_link"
                                                            class="form-control  @error('facebook_link') is-invalid @enderror"
                                                            maxlength="150" id="facebook_link" placeholder="Enter Your facebook link"
                                                            value="{{ old('facebook_link') ? old('facebook_link') : $member->facebook_link }}"
                                                            autocomplete="off">
                                                        @error('facebook_link')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- Facebook end -->
                                                
                                                <!-- youtube link start-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;"></span>YouTube link
                                                        <input type="text" name="youtube_link"
                                                            class="form-control  @error('youtube_link') is-invalid @enderror"
                                                            maxlength="150" id="youtube_link" placeholder="Enter Your YouTube link"
                                                            value="{{ old('youtube_link') ? old('youtube_link') : $member->youtube_link }}"
                                                            autocomplete="off">
                                                        @error('youtube_link')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- youtube link end-->
                                                <!-- Instagram link -->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <span style="color:red;"></span>Instagram link
                                                            <input type="text" name="instagram_link"
                                                                class="form-control  @error('instagram_link') is-invalid @enderror"
                                                                maxlength="150" id="instagram_link" placeholder="Enter Your Instagram link"
                                                                value="{{ old('instagram_link') ? old('instagram_link') : $member->instagram_link }}"
                                                                autocomplete="off">
                                                            @error('instagram_link')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                <!-- Instagram link end-->
                                                <!-- LinkedIn link -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;"></span>LinkedIn link
                                                        <input type="text" name="linkedin_link"
                                                            class="form-control  @error('linkedin_link') is-invalid @enderror"
                                                            maxlength="150" id="linkedin_link" placeholder="Enter Your LinkedIn link"
                                                            value="{{ old('linkedin_link') ? old('linkedin_link') : $member->linkedin_link }}"
                                                            autocomplete="off">
                                                        @error('linkedin_link')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Google link -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;"></span>Google link/Website
                                                        <input type="text" name="google_link"
                                                            class="form-control  @error('google_link') is-invalid @enderror"
                                                            maxlength="150" id="google_link" placeholder="Enter Your Google link"
                                                            value="{{ old('google_link') ? old('google_link') : $member->google_link }}"
                                                            autocomplete="off">
                                                        @error('google_link')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- New socialmidiya input code end -->
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <form action="{{ route('profile.change-password') }}" method="POST">
                                            @csrf
                                            <div class="row g-2" style="align-items: end;">
                                                <div class="col-lg-3">
                                                    <div>
                                                        <span style="color:red;">*</span>Old
                                                        Password
                                                        <input type="password" name="current_password"
                                                            class="form-control @error('current_password') is-invalid @enderror"
                                                            id="oldpasswordInput" placeholder="Enter current password"
                                                            required>
                                                        @error('current_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div>
                                                        <span style="color:red;">*</span>New
                                                        Password
                                                        <input type="password"
                                                            class="form-control @error('new_password') is-invalid @enderror"
                                                            required name="new_password"id="newpasswordInput"
                                                            placeholder="Enter new password" minlength="4"
                                                            maxlength="20">
                                                        @error('new_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div>
                                                        <span style="color:red;">*</span>Confirm
                                                        Password
                                                        <input type="password"
                                                            class="form-control @error('new_confirm_password') is-invalid @enderror"
                                                            name="new_confirm_password" required id="confirmpasswordInput"
                                                            minlength="4" maxlength="20" placeholder="Confirm password">
                                                        @error('new_confirm_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-success">Change
                                                            Password</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

            </div>
            <!-- container-fluid -->
        </div><!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © GroathAnOathToGrow.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->
@endsection
