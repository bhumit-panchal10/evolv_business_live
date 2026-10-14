
@extends('layouts.app')
@section('title', 'Reference List')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
<style>
        .box {
            border: 2px solid #78c046;
            border-radius: 6px;
            text-align: center;
            margin: 0 auto;
            padding: 20px;
            margin: 12px 0px;
        }

        .box .quote i {
            margin-top: 10px;
            font-size: 45px;
            color: #17c0eb
        }

        .box .image {
            margin: 10px 0;
            height: 150px;
            width: 150px;
            background: #78c046;
            padding: 3px;
            border-radius: 50%;
            margin: 0 auto;
        }

        .box .image img {
            height: 100%;
            width: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        .box p {
            text-align: justify;
            margin-top: 8px;
            font-size: 16px;
            font-weight: 400;
        }

        .box .name_job {
            margin: 10px 0 3px 0;
            color: #78c046;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .rating i {
            font-size: 18px;
            color: #78c046;
            margin-bottom: 5px;
        }

        .btns {
            margin-top: 20px;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .btns button {
            background: #78c046;
            width: 100%;
            padding: 9px 0px;
            outline: none;
            border: 2px solid #78c046;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 400;
            color: #78c046;
            transition: all 0.3s linear;
        }

        .btns button:first-child {
            background: none;
            margin-right: 5px;
        }

        .btns button:last-child {
            color: #fff;
            margin-left: 5px;
            background: #78c046;
        }
         
         
         .social-icons{
    gap: 10px;
    justify-content: space-around;
    align-items: baseline;
    margin: 20px 0px;
    flex-direction: column;
         }

        .social-icons a {
            position: relative;
            height: 40px;
            width: 40px;
            margin: 0 5px;
            display: inline-flex;
            text-decoration: none;
            border-radius: 50%;
            background: #78c046;
        }
            .cmp-name{
                text-align: center;
                font-size: 20px;
                font-weight: 700;
                color: #76be54;
                }

        .social-icons a i {
            position: relative;
            z-index: 3;
            text-align: center;
            width: 100%;
            height: 100%;
            line-height: 40px;
        }

       .br1{
           border: 2px solid #78c046;
           height:360px;
           
       }  

       .stf{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
       }
       .cmp-lg{
        width: 50px;
        border-radius: 50%;
        height: 50px;
       }
</style>
                                <div class="main-content">
                                    <div class="page-content">
                                        <div class="container-fluid">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <h5 class="card-title mb-0 text-white" data-anchor="data-anchor">Member List
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                    <div class="row">
                                                  
                                                    @foreach($members as $member)
                                                        <div class="col-12 col-md-6 col-lg-4">
                                                            <div class="card">
                                                                <div class="card-header stf" >
                                                                @if($member->Company_logo == null)    
                                                                <img class="cmp-lg" src="https://groath.in/assets/images/users/user1.png" alt="No image" class="company-logo">
                                                                @else 
                                                                <img class="cmp-lg" src="{{ asset('Company_logo') . '/' . $member->Company_logo }}" alt="No image" class="company-logo">
                                                                @endif
                                                                    <div>
                                                                        <h6 class="cmp-name text-white text-center mb-0">{{$member->companyname}}</h6>
                                                                        <p class="cmp-name text-white text-center mb-0" style="font-size: 12px;">{{$member->categories_name ?? ''}}</p> 
                                                                    </div>
                                                                </div>
                                                                <div class="card-body br1 p-4 text-center">  
                                                                @if($member->profile_photo == null)    
                                                                <img class="cmp-lg" src="https://groath.in/assets/images/users/undraw_profile.webp" alt="No image" class="company-logo">
                                                                @else 
                                                                <img class="cmp-lg" src="{{ asset('profile_photo') . '/' . $member->profile_photo }}" alt="No image" class="company-logo">
                                                                @endif                
                                                                <div class="user-name">{{$member->Contact_person}} - {{$member->group_name ?? 'No group name'}} </div>
                                                                    <div class="social-icons d-flex justify-content-between">
                                                            <div><a href="#" class=""><i class="fa fa-envelope text-white" aria-hidden="true"></i></a>{{$member->email}}</div>
                                                            <div>
                                                                <a href="tel:+91{{$member->phonenumber}}" class="">
                                                                    <i class="fa fa-phone text-white" aria-hidden="true"></i>
                                                                </a>
                                                                {{$member->phonenumber}}
                                                                
                                                            </div>

                                                            <div class="site-social-icons">
                                                            @if(isset($member->phonenumber))
                                                                <a class="text-white" href="https://wa.me/91{{$member->phonenumber}}" class="ml-2" target="_blank">
                                                                    <i style="
                                                                    font-size: 22px;
                                                                    color: white !important;" class="fa-brands fa-whatsapp text-success"
                                                                    aria-hidden="true"></i>
                                                                </a>
                                                            @endif       
                                                            @if(isset($member->facebook_link))
                                                              <a target="_blank" href="{{$member->facebook_link}}"><i class="fa-brands fa-facebook-f text-white"></i></a>
                                                            @endif
                                                            @if(isset($member->instagram_link))
                                                            <a target="_blank" href="{{$member->instagram_link}}"><i class="fa-brands fa-instagram text-white"></i></a>
                                                            @endif
                                                            @if(isset($member->youtube_link))
                                                            <a target="_blank" href="{{$member->youtube_link}}"><i class="fa-brands fa-youtube text-white"></i></a>
                                                            @endif
                                                            @if(isset($member->linkedin_link))
                                                            <a target="_blank" href="{{$member->linkedin_link}}"><i class="fa-brands fa-linkedin text-white"></i></a>
                                                            @endif
                                                            @if(!empty($member->google_link) && $member->google_link !== "-")
                                                                <a target="_blank" href="{{ $member->google_link }}"><i class="fa-brands fa-google-plus-g text-white"></i></a>
                                                            @endif
                                                            <!-- @if(isset($member->google_link))
                                                            <a target="_blank" href="{{$member->google_link}}"><i class="fa-brands fa-google-plus-g text-white"></i></a>
                                                            @endif -->

                                                            </div>
                                                        </div>
                                                    <div>
                                                        <a class="btns" href="{{ route('Membersearch.Detail',$member->id) }}">
                                                            <button>Product & Services</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div> 
                                     <!-- Pagination Links -->
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $members->links() }}
                                        </div>              
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
@endsection