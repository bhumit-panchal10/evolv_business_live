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
    .bg-white3 {
        background-color: white;
        padding: 25px;
        border-radius: 4px;
        box-shadow: 10px 30px 30px 30px rgba(0, 0, 0, .1);
        text-align: center;
    }

    .color-btn {
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
        font-weight: 600;
        transition: all 0.8s ease-out;
    }

    .login-area {
        background: url(../images/img/hands.png) no-repeat;
        background-size: cover;
        background-position: center;
    }
</style>

<section class="login-area mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 no-padding">
                <div class="pad-tb-50">
                    <div class="bg-white3">
                        <h1 class="frm-hds">The Cluster Fest 3.0</h1>
                        <h2 class="frm-hds">Thank You For Valuable Feedback : {{ $feedbackCount }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
