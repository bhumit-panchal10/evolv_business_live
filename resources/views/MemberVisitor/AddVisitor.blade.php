@extends('layouts.app')
@section('title', 'Award Add')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="mb-5" style="color:red">{{ $error }}</li>
                    @endforeach
                @endif

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Visitor</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('MemberVisitor.store') }}" method="post"
                                        enctype="multipart/form-data">

                                        @csrf
                                        {{-- <input type="hidden" name ="memberid" value="{{ $memberid }}"> --}}
                                        <div class="row gy-3 mb-3">
                                            <div class="col-lg-3 col-md-6">
                                                <span style="color:red;">*</span> Visitor Name
                                                <input type="text" class="form-control" name="name" id="visitorname"
                                                    placeholder="Enter Name" maxlength="100" autocomplete="off" required>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                               Phone
                                                <input type="text" class="form-control" name="phone" id="phone"
                                                    placeholder="Enter Phone" maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                    autocomplete="off">
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                Email
                                                <input type="text" class="form-control" name="email" id="email"
                                                    placeholder="Enter Email" maxlength="70" autocomplete="off">
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                Social Media
                                                <input type="checkbox" class="form-input" name="social_media" id="social_media" value="1"
                                                     autocomplete="off">
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                Member Name
                                                <span style="color:red;"
                                                    class="error-message">{{ $errors->first('member_id') }}</span>
                                                <select class="form-control" data-choices name="member_id"
                                                    id="choices-single-default-given-by">
                                                    <option value="" disabled selected>Select Member Name</option>
                                                    @foreach ($Data as $data)
                                                        <option value="{{ $data->member_id }}">
                                                            {{ $data->first_name }} - ({{ $data->mobile_number }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                Business Category
                                                <select class="form-select select2" id="business_category_id"
                                                    name="business_category_id" data-choices name="name">
                                                    <option value="">SelectCategory</option>
                                                    @php
                                                        $search = \App\Models\Categories::select(
                                                            'categories.id',
                                                            'categories.name',
                                                        )
                                                            ->where(['iStatus' => 1, 'isDelete' => 0])
                                                            ->orderBy('categories.name', 'asc')
                                                            ->get();
                                                    @endphp
                                                    @foreach ($search as $categori)
                                                        <option value="{{ $categori->id }}"
                                                            {{ isset($category_id) && $categori->id == $category_id ? 'selected' : '' }}>
                                                            {{ $categori->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <span style="color: red;">*</span>Meeting
                                                <span style="color:red;"
                                                    class="error-message">{{ $errors->first('meeting') }}</span>
                                                <select class="form-control" data-choices name="meeting"
                                                    id="choices-single-default-given-by">
                                                    <option value="" disabled selected>Select meeting</option>
                                                    @foreach ($futureMeetings as $meeting)
                                                        <option value="{{ $meeting->id }}">{{ $meeting->Meeting_title }}
                                                            -
                                                            ({{ $meeting->start_date }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <span style="color:red;">*</span>Business Name
                                                <input type="text" class="form-control" name="business_name"
                                                    id="business_name" placeholder="Enter Business Name" maxlength="70"
                                                    autocomplete="off" required>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <label for="photo">Proof Of
                                                    Payment</label>
                                                <input type="file" class="form-control" name="photo" id="photovalidate"
                                                    placeholder="Enter photo" value="{{ old('photo') }}">

                                                <div id="viewimg" style="margin-top:10px;"></div>

                                            </div>
                                             <div class="col-lg-3 col-md-6">
                                                Payment Mode
                                                <input type="text" class="form-control" name="mode" id="mode"
                                                    placeholder="Enter Mode" maxlength="70" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row gy-3">

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-success btn-user"
                                                    style="width:
                                                    81px; height: 36px;">Submit</button>
                                                <button type="button" class="btn btn-danger btn-user"
                                                    style="width:
                                                    81px; height: 34px;"
                                                    onclick="cancelForm()">Cancel</button>
                                            </div>

                                        </div>
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
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png',
                'webp'
            ];
            var fileExtension = document.getElementById('photovalidate').value.split('.').pop().toLowerCase();
            var isValidFile = false;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }

            if (!isValidFile) {
                alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
            }

            return isValidFile;
        }
    </script>

    {{-- Add photo --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#photovalidate").change(function() {
            var input = this;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewimg').html(
                        '<img src="' + e.target.result +
                        '" width="100" height="100" style="border:1px solid #ccc; padding:5px;">'
                    );
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>

@endsection
