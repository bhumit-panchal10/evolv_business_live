@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)
<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
{!! $seo->body !!}
@endsection
@section('content')

    <style>
        .frm-inp {
            /* display: flex; */
            justify-content: space-between;
        }
        .frm-inp input {
            width: 100% !important;
            margin: 8px 0px;
            padding: 10px;
        }
        .frm-inp select {
            width: 100%;
            width: 100% !important;
            margin: 8px 0px;
            padding: 10px;
        }
        .site-contact .left {
            min-height: 1061px;
            position: relative;
            background-color: white;
            overflow: hidden;
            padding: 0px;
            background: url(/../Groath/front/images/office.jpg) no-repeat top center;
            background-size: cover;
        }
        .site-contact .site-contact-info {
            margin: auto;
            padding: 45px;
            display: block;
            width: 70%;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            clear: both;
            background: rgba(255, 255, 255, .9);
            border-radius: 8px;
            margin-top: 90px;
            margin-bottom: 90px;
        }
     
        .bg-reg {
            background: url(/../Groath/front/images/office.jpg) no-repeat top center;
            background-size: cover;
        }
        input[type="file"] {
            border: 1px solid rgb(133, 133, 133) !important;
        }
        
        .color-btn{
            width: 100%;
            height: 45px;
            color: white !important;
            border: none;
            outline: none;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: linear-gradient(to right, rgb(120, 192, 70), rgb(38, 169, 205));
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
            transition: all 0.8s ease-out;
                }
                
                .bg-white3 {
        background-color: white;
            padding: 25px;
            border-radius: 4px;
            /* background: #EEEEEE; */
            background-color: rgb(255 255 255);
            box-shadow: 10px 30px 30px 30px rgba(0,0,0,.1);
        }


        .login-area {
            background: url(../images/img/hands.png) no-repeat;
            background-size: cover;
            /* background-size: 100% 100%; */
            background-position: center;
        }
    </style>
    <section class="login-area mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
            {{-- Alert Messages --}}
                @include('common.alert')
                 @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="mb-5" style="color:red">{{ $error }}</li>
                    @endforeach
                @endif
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 no-padding">
                    <div class="pad-tb-50">
                        <!-- Contact information -->
                        <div class="bg-white3">
                            <!-- H1 heading -->
                            <h1 class="frm-hds text-center"> Cluster Meet Registration</h1>
                            <form action="{{route('clustermeet')}}" method="post" enctype="multipart/form-data">
                                @csrf
                            
                            <div class="frm-inp">
                                <input type="text" placeholder="Enter Your Name" id="nameInput" name="name" maxlength="50" value="{{old('name')}}" required>
                                <input type="hidden" placeholder="Enter Your Phone Number" id="PhonenumberInput" name="Phonenumber" value="-" required>
                                  <input type="hidden" placeholder="Enter Your Phone Number" id="city_group" name="city_group" value="groath" required>
                                <input type="hidden" name="type" value=" cross cluster">
                            </div>
                            {{-- new field add start--}}
                            <div class="frm-inp">
                                <select name="droup_down" id="droup_down" placeholder="" required>
                                    <option value="">Select timing</option>
                                    @foreach ($available_dates as $date)
                                        <option value="{{ $date }}">{{ $date }}</option>
                                    @endforeach
                                </select>
                            </div>                 
                            
                            <!--<div class="frm-inp">-->
                            <!--    <select name="city_group" id="city_group" placeholder="" required>-->
                            <!--        <option value="">Select</option>-->
                            <!--        @foreach ($citygroup as $group)-->
                            <!--            <option value="{{ $group->id }}">{{ $group->group_name }}</option>-->
                            <!--        @endforeach-->
                            <!--    </select>-->
                            <!--</div>    -->
                            {{-- new field end  --}}
                              <div class="payment-container">
                                    <p>Notes :</p>
                                     <ol>
                            
                                         <li>This is your mandatory meeting.</li>
                                         <li>Date once chosen will not be changeable.</li>
                                         <li>Maximum 10 registered members will be there in this format of meet.</li>
                                         <li>Invite a good connect to join the meet as visitor.</li>
                                     </ol>
                                </div>
                            <div class="text-center mt-4">
                                
                                <button type="submit" class="theme-btn color-btn" style="">Submit</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
