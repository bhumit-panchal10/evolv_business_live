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
        .custom-select {
            position: relative;
            width: 100%;
        }

        .select-box {
            border: 1px solid #ccc;
            padding: 10px;
            cursor: pointer;
        }

        .dropdown-list {
            display: none;
            position: absolute;
            border: 1px solid #ccc;
            background-color: white;
            z-index: 1000;
            max-height: 150px;
            overflow-y: auto;
            width: 100%;
        }

        .dropdown-list label {
            display: block;
            padding: 5px;
            cursor: pointer;
        }

        .dropdown-list label:hover {
            background-color: #f1f1f1;
        }




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
            box-shadow: 10px 30px 30px 30px rgba(0, 0, 0, .1);
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
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 no-padding">
                    <div class="pad-tb-50">
                        <!-- Contact information -->
                        <div class="bg-white3">
                            <!-- H1 heading -->
                            <h1 class="frm-hds text-center">GrOath Cluster Meet </h1>
                            <!--<h6 class="frm-hds text-center">(19-04-2025)</h6>-->
                            <h3 class="frm-hds text-center">Visitor registration</h3>
                            <form action="{{ route('inductionstore_add') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="frm-inp">
                                    <input type="text" placeholder="Name" id="" name="contact_person_name"
                                        maxlength="50" value="{{ old('contact_person_name') }}" required>
                                    <input type="phonenumber" placeholder="Phonenumber" id="PhonenumberInput"
                                        name="Phonenumber"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        onKeyPress="if(this.value.length==10) return false;" maxlength="10" minlength="10"
                                        value="{{ old('Phonenumber') }}" required>
                                </div>
                                <div class="frm-inp">
                                    <input type="text" placeholder="Email" id="" name="email"
                                        value="{{ old('email') }}" required>
                                </div>

                                <div class="frm-inp">
                                    <input type="text" placeholder="Brand name" id="nameInput" name="name"
                                        maxlength="50" value="{{ old('name') }}" required>
                                </div>
                                <!-- 21-09-2024 -->
                                <div class="frm-inp">
                                    <input type="phonenumber" placeholder="Gst Number" id="Gst Numabr" name="gstnumber"
                                        maxlength="" minlength="0" value="{{ old('gstnumber') }}">
                                </div>
                                <!-- 21-09-2024 -->
                                <div class="frm-inp">
                                    <input type="text" placeholder="Brand category" id="category_id" name="category_id"
                                        maxlength="50" value="{{ old('category_id') }}" required>

                                </div>
                                <!-- <div class="frm-inp">
                                                                    <select name="category_id" id="droup_down" required>
                                                                        <option value="">Select business category</option>
                                                                        @foreach ($category as $data)
    <option value="{{ $data->id }}">{{ $data->name }}</option>
    @endforeach
                                                                    </select>
                                                                </div> -->
                                <div class="frm-inp">
                                    <select name="type" id="type" required>
                                        <option value="">Select time</option>
                                        <option value="2nd Feb 2026(08:15 AM to 10.15 AM)">2nd Feb 2026(08:15 AM to 10.15 AM)`</option>
                                        <option value="3rd Feb 2026(08:15 AM to 10.15 AM)">3rd Feb 2026(08:15 AM to 10.15 AM)</option>
                                        <option value="4th Feb 2026(08:15 AM to 10.15 AM)">4th Feb 2026(08:15 AM to 10.15 AM)</option>
                                        <option value="5th Feb 2026(08:15 AM to 10.15 AM)">5th Feb 2026(08:15 AM to 10.15 AM)</option>
                                        <option value="6th Feb 2026(08:15 AM to 10.15 AM)">6th Feb 2026(08:15 AM to 10.15 AM)</option>
                                        <option value="9th Feb 2026(04:00 PM TO 06:00 PM)">9th Feb 2026(04:00 PM TO 06:00 PM)</option>
                                        <option value="10th Feb 2026(04:00 PM TO 06:00 PM)">10th Feb 2026(04:00 PM TO 06:00 PM)</option>
                                        <option value="11th Feb 2026(04:00 PM TO 06:00 PM)">11th Feb 2026(04:00 PM TO 06:00 PM)</option>
                                        <option value="12th Feb 20265(04:00 PM TO 06:00 PM)">12th Feb 2026(04:00 PM TO 06:00 PM)</option>
                                         <option value="13th Feb 2026(04:00 PM TO 06:00 PM)">13th Feb 2026(04:00 PM TO 06:00 PM)</option>
                                        <option value="16th Feb 2026(05:30 PM to 07:30 PM)">16th Feb 2026(05:30 PM to 07:30 PM)</option>
                                        <option value="17th Feb 2026(05:30 PM to 07:30 PM)">17th Feb 2026(05:30 PM to 07:30 PM)</option>
                                        <option value="18th Feb 2026(05:30 PM to 07:30 PM)">18th Feb 2026(05:30 PM to 07:30 PM)</option>
                                        <option value="19th Feb 2026(05:30 PM to 07:30 PM)">19th Feb 2026(05:30 PM to 07:30 PM)</option>
                                         <option value="20th Feb 2026(05:30 PM to 07:30 PM)">20th Feb 2026(05:30 PM to 07:30 PM)</option>
                                    </select>
                                </div>
                                <div class="frm-inp">
                                    <select name="referred_by" id="referred_by" required>
                                        <option value="">Referred by</option>
                                        <option value="Groath member">Groath member</option>
                                        <option value="Other resource">Other resource</option>
                                    </select>
                                </div>
                                <div class="frm-inp">
                                    <input type="text" placeholder="Reference name" id="reference_name"
                                        name="reference_name" maxlength="50" value="{{ old('reference_name') }}">
                                </div>

                                <div class="payment-container">
                                    <p>Visitor fee : ₹ 600(%18 GST)</p>
                                    <input type="hidden" placeholder="amount_fee" id="amount_fee" name="amount_fee"
                                        value="708" required>
                                    <!-- <p>For payment scan QR </p> -->
                                    <div class="text-center">
                                        <!-- <img width="150" src="{{ asset('/front/images/groathqr.jpg') }}" alt="QR Code for Payment"> -->
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <!--<button type="submit" class="theme-btn color-btn" style="">Pay Now</button>-->
                                    <button type="submit" class="theme-btn color-btn"
                                        onclick="this.disabled=true; this.innerText='Processing...'; this.form.submit();">
                                        Pay Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('select-box').addEventListener('click', function() {
            document.getElementById('dropdown-list').style.display =
                document.getElementById('dropdown-list').style.display === 'none' ? 'block' : 'none';
        });

        document.querySelectorAll('.dropdown-list input[type=checkbox]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                let selectedValues = [];
                let checkedCount = document.querySelectorAll('.dropdown-list input[type=checkbox]:checked')
                    .length;

                if (checkedCount > 2) {
                    this.checked = false;
                    alert('You can only select up to two options.');
                    return;
                }

                document.querySelectorAll('.dropdown-list input[type=checkbox]:checked').forEach(function(
                    checkedBox) {
                    selectedValues.push(checkedBox.value);
                });

                document.getElementById('select-box').innerText = selectedValues.length ? selectedValues
                    .join(', ') : 'Select';
            });
        });

        window.addEventListener('click', function(event) {
            if (!event.target.matches('.select-box')) {
                let dropdowns = document.getElementsByClassName('dropdown-list');
                for (let i = 0; i < dropdowns.length; i++) {
                    let openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                    }
                }
            }
        });
    </script>

    <script>
        document.getElementById('referred_by').addEventListener('change', function() {
            var referenceNameInput = document.getElementById('reference_name');
            var selectedValue = this.value;

            if (selectedValue === 'From member') {
                referenceNameInput.placeholder = 'Enter Groath member name';
            } else if (selectedValue === 'Other resource') {
                referenceNameInput.placeholder = 'Enter other resource name';
            } else {
                referenceNameInput.placeholder = 'Enter reference name';
            }
        });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('form');
        const button = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function () {
            // Disable the button immediately
            button.disabled = true;
            button.innerText = 'Processing...'; // optional text change

            // Optional: add a spinner effect
            button.style.opacity = '0.6';
            button.style.cursor = 'not-allowed';
        });
    });
</script>
@endsection
