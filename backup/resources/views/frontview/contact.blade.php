@extends('layouts.front')
@section('title', 'Contact')
@section('content')
    
    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url({{ asset('assets/frontimages/catagory/MB-Herbals-Banner-5.webp') }});">
        <h2 class="ltext-105 cl0 txt-center">
            Contact
        </h2>
        <p class="cn-h-sb">Phoenix Medicaments Pvt. Ltd.</p>
    </section>


    <!-- Content page -->
    <!--<section class="bg0 p-t-104 p-b-116">-->
    <!--    <div class="container">-->
    <!--        <div class="flex-w flex-tr">-->
    <!--            <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">-->
    <!--                <form id="myForm" method="post" action="{{ route('contact_us') }}">-->
    <!--                    @csrf-->
    <!--                    <h4 class="mtext-105 cl2 txt-center p-b-30">-->
    <!--                        Send Us A Message-->
    <!--                    </h4>-->

    <!--                    <div class="bor8 m-b-20 how-pos4-parent">-->
    <!--                        <input class="sphone-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="name"-->
    <!--                            placeholder="Your Name" value="{{ old('name') }}" required autocomplete="off">-->
    <!--                        <img class="how-pos4 pointer-none" src="{{ asset('assets/frontimages/icons/icon-email.png') }}"-->
    <!--                            alt="ICON">-->
    <!--                        @error('name')
        -->
        <!--                            <strong class="text-danger">{{ $message }}</strong>-->
        <!--
    @enderror-->
    <!--                    </div>-->

    <!--                    <div class="bor8 m-b-20 how-pos4-parent">-->
    <!--                        <input class="sphone-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="mobile"-->
    <!--                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"-->
    <!--                            maxlength="10" minlength="10" placeholder="Your Mobile" value="{{ old('mobile') }}" required-->
    <!--                            autocomplete="off">-->
    <!--                        <img class="how-pos4 pointer-none" src="{{ asset('assets/frontimages/icons/icon-email.png') }}"-->
    <!--                            alt="ICON">-->
    <!--                        @error('mobile')
        -->
        <!--                            <strong class="text-danger">{{ $message }}</strong>-->
        <!--
    @enderror-->
    <!--                    </div>-->

    <!--                    <div class="bor8 m-b-20 how-pos4-parent">-->
    <!--                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="email"-->
    <!--                            placeholder="Your Email Address" value="{{ old('email') }}" required autocomplete="off">-->
    <!--                        <img class="how-pos4 pointer-none" src="{{ asset('assets/frontimages/icons/icon-email.png') }}"-->
    <!--                            alt="ICON">-->
    <!--                        @error('email')
        -->
        <!--                            <strong class="text-danger">{{ $message }}</strong>-->
        <!--
    @enderror-->
    <!--                    </div>-->

    <!--                    <div class="bor8 m-b-30">-->
    <!--                        <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="message" placeholder="How Can We Help?">{{ old('message') }}</textarea>-->
    <!--                    </div>-->

    <!--                    <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">-->
    <!--                        <div class="form-group mt-4 mb-4">-->
    <!--                            <div class="captcha">-->
    <!--                                <span> {!! captcha_img() !!} </span>-->
    <!--                                <button type="button" class="btn btn-danger" class="reload" id="reload">&#x21bb;-->
    <!--                                </button>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"-->
    <!--                            name="captcha" required>-->
    <!--                        @error('captcha')
        -->
        <!--                            <strong class="text-danger">{{ $errors->first('captcha') }} </strong>-->
        <!--
    @enderror-->
    <!--                    </div>-->

    <!--                    <button-->
    <!--                        class="flex-c-m main-clr stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">Submit-->
    <!--                    </button>-->
    <!--                </form>-->
    <!--            </div>-->

    <!--            <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">-->
    <!--                <div class="flex-w w-full p-b-42">-->
    <!--                    <span class="fs-18 cl5 txt-center size-211">-->
    <!--                        <span class="lnr lnr-map-marker"></span>-->
    <!--                    </span>-->

    <!--                    <div class="size-212 p-t-2">-->
    <!--                        <span class="mtext-110 cl2">-->
    <!--                            Address-->
    <!--                        </span>-->

    <!--                        <p class="stext-115 cl6 size-213 p-t-18">-->
    <!--                            Phoenix medicaments Pvt Ltd-->
    <!--                            F-80, F-81, Tulsi Industrial Estate Opp Bhagyoday Hotel, Changodhar – 382213-->
    <!--                        </p>-->
    <!--                    </div>-->
    <!--                </div>-->

    <!--                <div class="flex-w w-full p-b-42">-->
    <!--                    <span class="fs-18 cl5 txt-center size-211">-->
    <!--                        <span class="lnr lnr-phone-handset"></span>-->
    <!--                    </span>-->

    <!--                    <div class="size-212 p-t-2">-->
    <!--                        <span class="mtext-110 cl2">-->
    <!--                            Lets Talk-->
    <!--                        </span>-->

    <!--                        <p class="stext-115 cl1 size-213 p-t-18">-->
    <!--                            +91 8780418312-->
    <!--                        </p>-->
    <!--                    </div>-->
    <!--                </div>-->

    <!--                <div class="flex-w w-full">-->
    <!--                    <span class="fs-18 cl5 txt-center size-211">-->
    <!--                        <span class="lnr lnr-envelope"></span>-->
    <!--                    </span>-->

    <!--                    <div class="size-212 p-t-2">-->
    <!--                        <span class="mtext-110 cl2">-->
    <!--                            Sale Support-->
    <!--                        </span>-->

    <!--                        <p class="stext-115 cl1 size-213 p-t-18">-->
    <!--                            phoenixmbherbals@gmail.com-->
    <!--                        </p>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->


    <section class="mt-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-11 col-lg-10">
                    @include('common.contactalert')
                    <div class="row fm-shd2 align-items-center ">
                        <div class="col-12 col-md-6 col-lg-6 px-0">
                            <div class="flex-w flex-col-m p-tb-30 p-lr-15-lg w-full-md">
                                <div class="flex-w w-full p-b-42">
                                    <span class="fs-18 cl5 txt-center size-211">
                                        <span class="lnr lnr-map-marker text-white"></span>
                                    </span>

                                    <div class="size-212 p-t-2">
                                        <span class="mtext-110 cl2 cntc-heading">
                                            Address
                                        </span>

                                        <p class="stext-115 cl6 size-213 p-t-18 text-white">
                                            Phoenix medicaments Pvt Ltd </br>
                                            F-80, F-81, Tulsi Industrial Estate Opp Bhagyoday Hotel, Changodhar – 382213
                                        </p>
                                    </div>
                                </div>

                                <div class="flex-w w-full p-b-42">
                                    <span class="fs-18 cl5 txt-center size-211">
                                        <span class="lnr lnr-phone-handset text-white"></span>
                                    </span>

                                    <div class="size-212 p-t-2">
                                        <span class="mtext-110 cl2 cntc-heading">
                                            Lets Talk
                                        </span>

                                        <p class="stext-115 cl1 size-213 p-t-18 text-white">
                                            +91 8780418312
                                        </p>
                                    </div>
                                </div>

                                <div class="flex-w w-full">
                                    <span class="fs-18 cl5 txt-center size-211">
                                        <span class="lnr lnr-envelope text-white"></span>
                                    </span>

                                    <div class="size-212 p-t-2">
                                        <span class="mtext-110 cl2 cntc-heading">
                                            Sale Support
                                        </span>

                                        <p class="stext-115 cl1 size-213 p-t-18 text-white">
                                            phoenixmbherbals@gmail.com
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 px-0">
                            <div class="cn-pdt2">
                                <div>
                                    <p class="text-center sin text-uppercase">Send Us A Message</p>
                                </div>

                                <div class="cn-dt">
                                    <form id="myForm" action="{{ route('contact_us') }}" method="post">
                                        @csrf

                                        <div class="mail-rel">
                                            <span class="lnr lnr-user us mail2 mail-reg-icon"></span>
                                            <input type="text" name="name" placeholder="Enter Your Name"
                                                value="{{ old('name') }}" required>
                                            @error('name')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="mail-rel">
                                            <span class="lnr lnr-envelope mail2 mail-reg-icon"></span>
                                            <input type="email" name="email" placeholder="Enter Your Email"
                                                value="{{ old('email') }}" required>
                                            @error('email')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="signup-cl-rel">
                                            <span class="lnr lnr-phone-handset signup-cl-icon"></span>
                                            <input type="text" name="mobile" maxlength="10" minlength="10"
                                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                value="{{ old('mobile') }}" placeholder="Enter Your Mobile Number"
                                                required>
                                            @error('mobile')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div>
                                            <textarea class="w-100" name="message" id="" cols="30" placeholder="Enter Your Message"
                                                rows="4">
                                                 {{ old('message') }}
                                             </textarea>
                                        </div>



<div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">

                                    <div class="form-group mt-4 mb-4">
                                        <div class="captcha">
                                            <span>{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                &#x21bb;
                                            </button>
                                        </div>
                                    </div>
                                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                        name="captcha" required>
                                    @if ($errors->has('captcha'))
                                        <span class="help-block">
                                            <strong class="text-white">{{ $errors->first('captcha') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                        <div>
                                            <a class="log-bn" href="#"><button type="submit">SUBmit</button></a>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-5">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3674.9994042074254!2d72.43276747524426!3d22.913392820393838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e845517ddc763%3A0xc1fc8b29269e059c!2sPhoenix%20Medicaments%20Pvt.Ltd.!5e0!3m2!1sen!2sin!4v1705052484101!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            
        </iframe>
        
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script type="text/javascript">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'refresh_captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
    

    <script>
        $(document).ready(function() {
            $("#myForm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    captcha: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    }
                },
                messages: {
                    name: {
                        required: "Name is required",
                    },
                    captcha: {
                        required: "Captcha is required",
                    },
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                    },
                    mobile: {
                        required: "Mobile is required",
                        minlength: "Mobile must be of 10 digits",
                    },
                }
            });
        });
    </script>
@endsection
