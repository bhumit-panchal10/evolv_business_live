@extends('layouts.app')
@section('title', 'Admin user List')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __('Admin User Permission') }}</div>
                            <div class="card-body">
                                <form action="{{route('Userpermission.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user_id}}">
                                    <h2>{{ __('Master Entry') }}</h2>
                                    <div class="row align-items-center">
                                    <div class="form-group col-md-3">
                                        <label for="city">{{ __('Master Entry') }}</label><br>
                                        <select name="MasterEntry" class="form-control" value="">
                                            <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1" {{ isset($permission) && $permission->MasterEntry == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0" {{ isset($permission) && $permission->MasterEntry == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                   
                                    <div class="form-group col-md-3">
                                        <label for="city">{{ __('City') }}</label><br>
                                        <select name="city_permission" class="form-control" value="">
                                            <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1" {{ isset($permission) && $permission->city == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0" {{ isset($permission) && $permission->city == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="City_Group">{{ __('City Group') }}</label><br>
                                        <select name="city_group_permission" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->city_group == 1 ? "selected" : "" }} >{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->city_group == 0 ? "selected" : "" }} >{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="categories">{{ __('Categories') }}</label><br>
                                        <select name="categories_permission" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->categories == 1 ? "selected" : "" }} >{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->categories == 0 ? "selected" : "" }} >{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="membershipplans">{{ __('Membershipplans') }}</label><br>
                                        <select name="membershipplans_permission" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->membershipplans == 1 ? "selected" : "" }} >{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->membershipplans == 0 ? "selected" : "" }} >{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="overteem">{{ __('Our team') }}</label><br>
                                        <select name="overteem" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->overteem == 1 ? "selected" : "" }} >{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->overteem == 0 ? "selected" : "" }} >{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Banner">{{ __('Offer Banner') }}</label><br>
                                        <select name="Banner" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->Banner == 1 ? "selected" : "" }} >{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->Banner == 0 ? "selected" : "" }} >{{ __('No') }}</option>
                                        </select>
                                    </div>
                               
                                    <h2>{{ __('Member') }}</h2>
                                    <div class="form-group col-md-3">
                                        <label for="members">{{ __('Members') }}</label><br>
                                        <select name="members_permission" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->members == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->members == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                  
                                    <div class="form-group col-md-3">
                                        <label for="Products_service">{{ __('Products service') }}</label><br>
                                        <select name="Products_service_permission" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->Products_service == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->Products_service == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Renewalhistory">{{ __('Renewalhistory') }}</label><br>
                                        <select name="Renewalhistory" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->Renewalhistory == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->Renewalhistory == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <h2>{{ __('Business') }}</h2>
                                    <div class="form-group col-md-3">
                                        <label for="Business">{{ __('Business') }}</label><br>
                                        <select name="Business" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->Business == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->Business == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="reports">{{ __('reports') }}</label><br>
                                        <select name="reports" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->reports == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->reports == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Adminuser">{{ __('Adminuser') }}</label><br>
                                        <select name="Adminuser" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->Adminuser == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->Adminuser == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <h2>{{ __('Utility') }}</h2>
                                    <div class="form-group col-md-3">
                                        <label for="Utility">{{ __('Utility') }}</label><br>
                                        <select name="Utility" class="form-control">
                                        <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->Utility == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->Utility == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Blog">{{ __('Blog') }}</label><br>
                                        <select name="Blog" class="form-control">
                                        <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->Blog == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->Blog == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="gallery">{{ __('Gallery') }}</label><br>
                                        <select name="gallery" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->gallery == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->gallery == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="videogallery">{{ __('Videogallery') }}</label><br>
                                        <select name="videogallery" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->videogallery == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->videogallery == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Event">{{ __('Event') }}</label><br>
                                        <select name="Event" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->Event == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->Event == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="BannerImage">{{ __('Banner Image') }}</label><br>
                                        <select name="BannerImage" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->BannerImage == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->BannerImage == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="RegisterInquiry">{{ __('Register Inquiry ') }}</label><br>
                                        <select name="RegisterInquiry" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->RegisterInquiry == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->RegisterInquiry == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="ContactInquiry">{{ __('Contact Inquiry ') }}</label><br>
                                        <select name="ContactInquiry" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->ContactInquiry == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->ContactInquiry == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div>  
                                    <div class="form-group col-md-3">
                                        <label for="EventInquiry ">{{ __('Event Inquiry ') }}</label><br>
                                        <select name="EventInquiry" class="form-control">
                                             <option value="" {{ !isset($permission) ? "selected" : "" }}>{{ __('Select') }}</option>
                                            <option value="1"{{ isset($permission) && $permission->EventInquiry == 1 ? "selected" : "" }}>{{ __('Yes') }}</option>
                                            <option value="0"{{ isset($permission) && $permission->EventInquiry == 0 ? "selected" : "" }}>{{ __('No') }}</option>
                                        </select>
                                    </div> 
                                  </div>
                                  <br> 
                                    <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                                    <button type="button" class="btn btn-danger btn-user float-right" onclick="cancelForm()">{{ __('Cancel') }}</button>
                                </form>
                            </div>
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
        function cancelForm() {
            window.location.reload(); 
        }
    </script>

@endsection