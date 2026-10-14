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
                            <h3 class="frm-hds text-center">Your valuable Feedback</h3>

                            <form action="{{ route('ClusterfestFeedbackstore') }}" method="post">
                                @csrf

                                <div class="frm-inp">
                                    <input type="text" placeholder="Name" name="name"
                                        value="{{ old('name') }}" maxlength="50" required>
                                    <input type="text" placeholder="Brand Name" name="brand_name"
                                        value="{{ old('brand_name') }}" maxlength="50" required>
                                </div>

                                <div class="frm-inp">
                                    <input type="text" placeholder="Business Category" name="business_category"
                                        value="{{ old('business_category') }}" maxlength="100">
                                    <input type="email" placeholder="Email Address" name="email"
                                        value="{{ old('email') }}" maxlength="100" required>

                                        @error('email')
                                            <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="frm-inp">
                                    <select name="first_experience" required>
                                        <option value="">Was this your first business networking experience?</option>
                                        <option value="Yes" {{ old('first_experience') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('first_experience') == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>


                                <div class="frm-inp">
                                    <select name="experience_feedback" required>
                                        <option value="">Your Experience of The Cluster Fest 3.0</option>
                                        <option value="Beyond Expectation" {{ old('experience_feedback') == 'Beyond Expectation' ? 'selected' : '' }}>Beyond Expectation</option>
                                        <option value="As Per Expectation" {{ old('experience_feedback') == 'As Per Expectation' ? 'selected' : '' }}>As Per Expectation</option>
                                        <option value="Below Expectation" {{ old('experience_feedback') == 'Below Expectation' ? 'selected' : '' }}>Below Expectation</option>
                                    </select>
                                </div>

                                <div class="frm-inp">
                                    <select name="join_next_meet" id="join_next_meet" required>
                                        <option value="">Would you like to join the upcoming Cluster Meet?</option>
                                        <option value="Yes" {{ old('join_next_meet') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('join_next_meet') == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('join_next_meet')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="frm-inp" id="preferred_date_container" style="display:none;">
                                    <select name="preferred_date">
                                        <option value="">Select Preferred Date</option>

                                        {{-- Show only available dates from controller --}}
                                        @foreach ($available_dates as $date)
                                            <option value="{{ $date }}" {{ old('preferred_date') == $date ? 'selected' : '' }}>
                                                {{ $date }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Show validation error for preferred_date --}}
                                    @error('preferred_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>




                                <div class="text-center mt-4">
                                    <button type="submit" class="theme-btn color-btn">Submit Feedback</button>
                                </div>

                              
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
