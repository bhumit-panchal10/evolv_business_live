
@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <?php $sessionrole =Auth::user(); ?>
    <style>
    .table-responsive table {
        table-layout: fixed;
        width: 100%;
     }

    .table-responsive td {
        word-wrap: break-word;
        white-space: normal;
    }
    </style>
  
    <div class="main-content">

        {{-- Alert Messages --}}
        @include('common.alert')
        <div class="page-content">
            <div class="container-fluid mt-4">
                <div class="profile-foreground position-relative mx-n4 mt-n4">
                    <div class="profile-wid-bg">
                        <img src="https://evolv.co.in/evolv_business/assets/images/group_photo.jpeg" alt="" class="profile-wid-img" />
                    </div>
                </div>
                <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
                    <div class="row g-4">
                        <div class="col-auto">
                        @if($sessionrole->role_id == 2)
                          @if(isset($member->profile_photo))
                            <div class="avatar-lg">
                                <img src="{{ asset('profile_photo') . '/' . $member->profile_photo }}" alt="user-img " style="height: 100px; width: 100px; object-fit: cover;"
                                    class="img-thumbnail rounded-circle" />
                            </div>
                            @else 
                            <div class="avatar-lg">
                                <img src="{{ asset('assets/images/users/undraw_profile.webp') }}" alt="user-img"
                                    class="img-thumbnail rounded-circle" />
                            </div>
                            @endif
                        @else
                        <div class="avatar-lg">
                                <img src="{{ asset('assets/images/users/undraw_profile.webp') }}" alt="user-img"
                                    class="img-thumbnail rounded-circle" />
                            </div>

                        @endif 
                        </div>
                        <!--end col-->
                        <div class="col">
                            <div class="p-2">
                                <h3 class="text-white mb-1">{{ auth()->user()->full_name }}</h3>
                                <?php
                                $session = auth()->user()->id;
                                $role = App\Models\User::select('users.id', 'roles.name')
                                    ->where('users.id', $session)
                                    ->join('roles', 'users.role_id', '=', 'roles.id')
                                    ->first();
                                ?>
                                <p class="text-white-75">
                                    {{ $role->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <div class="d-flex">
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1"
                                    role="tablist">                                    
                                </ul>
                               @if($sessionrole->role_id == 2)
                               <div class="flex-shrink-0">
                                    <a href="{{ route('profile.UserEditProfile') }}" class="btn btn-success"><i
                                            class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                                </div>
                               @else
                                <div class="flex-shrink-0">
                                    <a href="{{ route('profile.EditProfile') }}" class="btn btn-success"><i
                                            class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                                </div>
                              @endif  
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content pt-4 text-muted">
                                <div class="tab-pane active" id="overview-tab" role="tabpanel">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6 col-xxl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3">User Information</h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless mb-0">
                                                            <tbody>
                                                                 @if(isset($member) && $member->priority_club_3_year == 1)
                                                                     <div class="text-center mt-3 mb-3">
                                                                        <span class="badge px-4 py-2"
                                                                            style="
                                                                                    background: linear-gradient(45deg, #ffcc00, #ff9900);
                                                                                    color: #000;
                                                                                    font-size: 15px;
                                                                                    font-weight: 700;
                                                                                    border-radius: 25px;
                                                                                    box-shadow: 0 4px 12px rgba(255, 153, 0, 0.4);
                                                                                    letter-spacing: 0.5px;
                                                                                ">
                                                                            ⭐ PRIORITY MEMBER
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                                <tr>
                                                                    <th class="ps-0" scope="row">Full Name :</th>
                                                                    <td class="text-muted">
                                                                        {{ old('first_name') ? old('first_name') : auth()->user()->full_name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="ps-0" scope="row">Mobile :</th>
                                                                    <td class="text-muted">
                                                                        {{ old('mobile_number') ? old('mobile_number') : auth()->user()->mobile_number }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="ps-0" scope="row">E-mail :</th>
                                                                    <td class="text-muted">
                                                                        {{ old('email') ? old('email') : auth()->user()->email }}
                                                                    </td>
                                                                </tr>
                                                                
                                                                <!-- MEMBER USER FIELD START -->
                                                               @if($sessionrole->role_id == 2)
                                                                    @if(isset($member->companyname))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Brand Name:</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->companyname ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->Brand_name))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Company Name:</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->Brand_name ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->address))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Address :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->address ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->date_of_birth))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Date of Birth :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->date_of_birth ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->work_anniversary_date))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Work Anniversary Date :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->work_anniversary_date ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->gstnumber))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Gst Number :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->gstnumber ?? '-' }}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->facebook_link))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Facebook Link :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->facebook_link ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->youtube_link))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">youtube Link :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->youtube_link ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->instagram_link))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Instagram Link :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->instagram_link ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->linkedin_link))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">LinkedIn Link :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->linkedin_link ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->google_link))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Google Link :</th>
                                                                            <td class="text-muted">
                                                                                {{ $member->google_link ?? '-'}}
                                                                            </td>
                                                                        </tr>
                                                                        @endif 
                                                                        @if(isset($member->SubscriptionExpiredDate))
                                                                        <tr>
                                                                            <th class="ps-0" scope="row">Subscription Expiry Date :</th>
                                                                            <td class="text-muted">
                                                                            {{ \Carbon\Carbon::parse($member->SubscriptionExpiredDate)->format('d-m-Y') }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif 
                                                                @endif
                                                                <!-- MEMBER USER FIELD END  -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Navdeep Product.
                    </div>

                </div>
            </div>
        </footer>
    </div>
@endsection


<!-- HEIGHT: 100px;
    width: 100px;
    object-fit: cover; -->
