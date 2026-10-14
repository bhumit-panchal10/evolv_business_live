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
            display: flex;
            justify-content: space-between;
        }
        .frm-inp input {
            width: 49% !important;
            margin: 8px 0px;
            padding: 10px;
        }
        .frm-inp select {
            width: 50%;
            width: 49% !important;
            margin: 8px 0px;
            padding: 10px;
        }
        .site-contact .left {
            min-height: 1061px;
            position: relative;
            background-color: white;
            overflow: hidden;
            padding: 0px;
            background: url(/../Evolv/front/images/office.jpg) no-repeat top center;
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
            background: url(/../Evolv/front/images/office.jpg) no-repeat top center;
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
                 <!-- @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="mb-5" style="color:red">{{ $error }}</li>
                    @endforeach
                @endif -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 no-padding">
                    <div class="pad-tb-50">
                        <!-- Contact information -->
                        <div class="bg-white3">
                            <!-- H1 heading -->
                            <h1 class="frm-hds text-center">Register</h1>
                            <form action="{{route("frontstore")}}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="frm-inp">
                                <input type="text" placeholder="Name *" id="nameInput" name="name" value="{{old('name')}}" maxlength="50" required >
                                <select name="business_segment" id="businessSegmentSelect" placeholder="Business Segment">
                                    <option value="">Business Segment</option>
                                    <option value="Product">Product</option>
                                    <option value="Service">Service</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            {{-- new field add start--}}
                            <!-- <div class="frm-inp">
                                <input type="text" placeholder="Enter Email *" id="emailInput" name="email" value="{{old('email')}}" required>
                                <input type="phonenumber" placeholder="Enter Phonenumber *" id="PhonenumberInput" name="Phonenumber" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" maxlength="10" minlength="10" value="{{old('Phonenumber')}}" required>
                            </div> -->
                            <div class="frm-inp">
                                <input type="text" placeholder="Enter Email *" id="emailInput" name="email" value="{{old('email')}}" required>
                                <input type="text" placeholder="Enter Phonenumber *" id="PhonenumberInput" name="Phonenumber" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                    onkeypress="if(this.value.length==10) return false;" 
                                    maxlength="10" minlength="10" pattern="\d{10}" title="Please enter exactly 10 digits" 
                                    value="{{old('Phonenumber')}}" required>
                            </div>

                            {{-- new field end  --}}
                             
                            <div class="frm-inp">
                                <select name="category" id="categorySelect" required>
                                    <option value="{{ old('category') == '' ? 'selected' : '' }}">Choose the correct category that identifies you<span class="text-danger"> *</span></option>
                                    <option value="Manufacturer">Manufacturer</option>
                                    <option value="Trader">Trader</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" placeholder="Name of the Business Firm *" name="businessFirm" id="businessNameInput" value="{{old('businessFirm')}}" maxlength="100" required>
                            </div>
                            <div class="frm-inp">
                                <input class="w-50" type="text" placeholder="Registered Office Address *" name="RegisteredOfficeAddress" value="{{old('RegisteredOfficeAddress')}}" maxlength="150" required>
                                <input class="w-50" type="text" placeholder="Address of any other workplace (Branch/factory) *" name="Other_Address" value="{{old('Other_Address')}}" maxlength="150" required>
                            </div>
                            <div class="frm-inp">
                                <select name="designation" id="designationSelect" required>
                                    <option value="{{ old('designation') == '' ? 'selected' : '' }}">Your designation at the firm<span class="text-danger"> *</span></option>
                                    <option value="Owner">Owner</option>
                                    <option value="Co-Owner">Co-Owner</option>
                                    <option value="Director">Director</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" placeholder="Year of Business Inception *" name="Business_Inception_year" maxlength="100" required>
                            </div>
                            <div class="frm-inp">
                                <select name="business_documents_brand" id="documentsSelect" required>
                                    <option value="{{old('business_documents_brand')}}">Select the valid business documents your brand has<span class="text-danger">*</span></option>
                                    <option value="Gst">GST</option>
                                    <option value="Certificate of Incorporation">Certificate of Incorporation</option>
                                    <option value="Health License">Health License</option>
                                    <option value="Company PAN">Company PAN</option>
                                    <option value="FSSAI">FSSAI</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="file" accept=".doc, .docx, .pdf, .jpeg, .jpg" placeholder="Kindly attach any of the above document for the record." name="documents" id="documentsInput" value="{{old('documents')}}" required>
                                
                            </div>
                            <div class="frm-inp">
                                <select name="annual_turnover" id="turnoverSelect" required>
                                    <option value="{{old('annual_turnover')}}">Average Annual Business Turnover <span class="text-danger">*</span></option>
                                    <option value="Less than 20 lakhs INR">Less than 20 lakhs INR</option>
                                    <option value="Between 20 lakhs to 50 Lakhs INR">Between 20 lakhs to 50 Lakhs INR</option>
                                    <option value="Above 50 lakhs INR">Above 50 lakhs INR</option>
                                </select>
                             
                                <select class="w-50" name="industry" id="industrySelect" required>
                                    <option value="{{old('industry')}}">Which industry do you represent? <span class="text-danger">*</span></option>
                                    @foreach($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <textarea placeholder="Sub-category of the industry" class="w-100" name="industry_subcategory" id="subcategoryTextarea" maxlength="150" cols="5" rows="3" required></textarea>
                            </div>
                            <div class="frm-inp">
                                <input type="file" accept=".doc, .docx, .pdf, .jpeg, .jpg" placeholder="Kindly attach any one document that can validate the business establishment year." name="business_establishment_year" id="business_establishment_year" value="{{old('business_establishment_year')}}" required>                            
                                <select name="chapter" id="chapterSelect" required>
                                    <option value="{{old('chapter')}}">Which Chapter do you wish to join? *</option>
                                    @foreach($citygroup as $citygroups)
                                        <option value="{{ $citygroups->id }}">{{ $citygroups->group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="frm-inp">
                                <input type="text" placeholder="Kindly mention the name of the representative who may attend in your absence with their designation in the company. *" name="representative_name" id="representativeInput" maxlength="100" required>
                                <select class="w-100" name="payment_mode" id="paymentModeSelect" required>
                                    <option value="{{old('payment_mode')}}">Kindly mention the mode of payment that you choose to pay membership fees</option>
                                    <option value="Online">Online</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
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
