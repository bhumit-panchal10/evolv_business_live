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
            justify-content: space-between;
        }

        .frm-inp input,
        .frm-inp select {
            width: 100% !important;
            margin: 8px 0px;
            padding: 10px;
        }

        .bg-white3 {
            background-color: white;
            padding: 25px;
            border-radius: 4px;
            box-shadow: 10px 30px 30px 30px rgba(0, 0, 0, .1);
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
             @if(session('success'))
                                <div class="alert alert-success text-center mb-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 no-padding">
                    <div class="pad-tb-50">
                        <div class="bg-white3">
                            <h1 class="frm-hds text-center">The Cluster Fest 3.0</h1>
                            <h3 class="frm-hds text-center">It's our previlege to have you with us. <br>Thank you for your valuable feedback</h3>

                            

                              
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    const joinNextMeet = document.getElementById('join_next_meet');
    const dateContainer = document.getElementById('preferred_date_container');

    function togglePreferredDate() {
        dateContainer.style.display = joinNextMeet.value === 'Yes' ? 'block' : 'none';
    }

    joinNextMeet.addEventListener('change', togglePreferredDate);

    // Run once on page load to restore state after validation error
    togglePreferredDate();
</script>


@endsection
