@extends('layouts.front')
@section('title', 'Contact')
@section('content')

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Payment Gateway</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style>
   .ship-head {
    padding: 6px;
    background: linear-gradient(to right, #78c046, #26a9cd);
    color: white;
    font-size: 16px;
    text-transform: uppercase;
    text-align: center;
    font-weight: 600;
    border: 1px solid black;
}

    .ship-inp{
        border:none;
        margin-bottom:0px;
        width:100%;
    }

    .b-none{
        border:none !important;
    }

    td{
    padding: 7px 10px;
    border: 1px solid black;
    }

    .pay-btn{
        background: linear-gradient(to right, #78c046, #26a9cd);
    width: 100%;
    padding: 10px;
    text-align: center;
    color: white !important;
    font-weight: 800;
    border-radius: 32px;
    }

    .can-btn{
        background: linear-gradient(to right, #78c046, #26a9cd);
    width: 100%;
    padding: 10px;
    text-align: center;
    color: white !important;
    font-weight: 800;
    border-radius: 32px;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="{{ asset('/front/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{asset('front/css/bootstrap-4.5.0.min.css')}}" rel="stylesheet">
<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
  
                        @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Error!</strong>{{ $message }}
                            </div>
                        @endif
  
                        @if($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Success!</strong> {{ $message }}
                            </div>
                        @endif
  
                      
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 15px;">                
                                <table width="40%" class="mx-auto" height="100" border='1' align="center">
                
                                    <tr>
                                        <td class="ship-head" colspan="2">Member information :</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Member Name :</td>
                                        <td><input class="ship-inp" type="text" name="billing_name" value="{{ $getdeta->contact_person_name }}" /></td>
                                    </tr>
                                    
             
                                    <tr>
                                        <td>Member Tel :</td>
                                        <td><input class="ship-inp" type="text" name="billing_tel" value="{{$getdeta->Phonenumber}}" /></td>
                                    </tr>
                
                                    <tr>
                                        <td>Email :</td>
                                        <td><input class="ship-inp" type="text" name="billing_email" value="{{$getdeta->email}}" /></td>
                                    </tr>
                
                                    <tr>
                                        <td>Amount :</td>
                                        <td><input class="ship-inp" type="text" name="amount" value="{{$Net_Amount}}" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td>Currency :</td>
                                        <td><input class="ship-inp" type="text" name="currency" value="INR" /></td>
                                    </tr>               
                
                                </table>
                                <table width="40%"  class="mx-auto  mb-5" height="100" border='1' align="center">
                                     <tr class="">
                                        <td width="50%" style="border: none;"><a href="" class="pay_now pay-btn flex-c-m stext-101 cl0 size-116 bg3  hov-btn3 p-lr-15 trans-04 pointer mb-0" data-amount="{{$Net_Amount}}" data-mobile="{{ $getdeta->Phonenumber }}" data-email="{{ $getdeta->email }}" data-order-id="{{ $order->id }}" data-order_id="{{ $Data }}">Pay Now</a></td>
                                        <td width="50%" style="border: none;"><a class="flex-c-m stext-101 can-btn cl0 size-116 bg3  hov-btn3 p-lr-15 trans-04 pointer" href="{{ route('FrontIndex') }}">Cancel</a></td>
                                    </tr>                
                                </table>
                            </div>                               
                            </div>                           
                        </div>
                      

                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('click', '.pay_now', function(e) 
        {
            var totalAmount = $(this).attr("data-amount");
            totalAmount = totalAmount * 100;
            var order_id = $(this).attr("data-order-id");
            var orderId = $(this).attr("data-order_id");            
            var mobile = $(this).attr("data-mobile");
            var email = $(this).attr("data-email");
            var url = "{{ route('razprpay.success') }}";
            var options = {
                "key": "{{ config('app.RAZORPAY_KEY') }}",
                "amount": totalAmount,
                "currency": "INR",
                "mobile": mobile,
                "email": email,
                "order_id": order_id,
                "handler": function(response)
                {
                    $.ajax({
                        url: url,
                        type: 'post',
                        //dataType: 'json',
                        data: {
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature : response.razorpay_signature,
                            razorpay_order_id : response.razorpay_order_id,
                            orderId : order_id,
                            iOrderId : orderId
                        },
                        success: function(msg) {
                           
                            if(msg == 1){
                                window.location.href = "{{route('razorpay.thankyou')}}";
                            }
                            else{
                                window.location.href = "{{route('razorpay.RazorFail')}}";
                            }

                        },
                        error: function (jqXHR, exception) {
                           
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            alert(msg);

                        },
                    });
                },
                "prefill":
                {
                    "contact": mobile,
                    "email": email,
                },
                "theme": {
                    "color": "#528FF0"
                }
            };
            var rzp1 = new Razorpay(options);
            //
            rzp1.on('payment.failed', function (response) {
            const orderId = "{{ $getdeta->id }}"; 
 
    // Redirect to payment fail route with order ID as a query param
    window.location.href = "{{ route('razorpay.RazorFail') }}" + "?order_id=" + orderId;
});
            //
            rzp1.open();
            e.preventDefault();
        });
    </script>
@endsection

