@extends('layouts.app')
@section('title', 'Announcement edit')
@section('content')
    {{-- {{ dd($data) }} --}}
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

                <!-- <div class="row">
                                                                                                                                                    <div class="col-10">
                                                                                                                                                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                                                                                                                            <h4 class="mb-sm-0">Add Members</h4>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div> -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Edit Announcement</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('MemberAnnouncement.update') }}" method="post"
                                        enctype="multipart/form-data">

                                        @csrf
                                        <input type="hidden" name ="memberid" value="{{ $memberid }}">
                                        <input type="hidden" name ="awardid" value="{{ $data->id }}">
                                        <div class="row gy-3 mb-3">
                                            <div class="col-lg-3 col-md-6">
                                                <span style="color:red;">*</span>Title
                                                <input type="text" class="form-control" name="title" id="title"
                                                    placeholder="Enter Title" value="{{ $data->title }}" maxlength="100"
                                                    autocomplete="off" required>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;"></span> Photo
                                                <input type="file" class="form-control" name="photo" id="editphoto"
                                                    value="{{ $data->photo }}" placeholder="Enter Image">
                                                {{-- <p class="help-block">Please upload a photo for your profile.</p> --}}
                                                <input type="hidden" name="hiddenPhoto" class="form-control"
                                                    value="{{ old('photo') ? old('photo') : $data->photos }}"
                                                    id="hiddenPhoto">
                                            </div>
                                            <div class="col-lg-4">
                                                <div id="viewimg">
                                                    @if ($data->photos)
                                                        <img src="{{ asset('MemberAnnouncement') . '/' . $data->photos }}"
                                                            alt="" height="70" width="70">
                                                    @else
                                                        <img src="https://groath.in/assets/images/noimage.png"
                                                            alt="No Image" height="70" width="70">
                                                    @endif
                                                    <!-- <img src="{{ asset('Award') . '/' . $data->photos }}" alt=""
                                                                                                                     height="70" width="70"> -->
                                                </div>
                                            </div>

                                        </div>

                                        <div>
                                            <div>
                                                <label for="description">
                                                    <span style="color:red;">*</span>Description
                                                </label>
                                                <textarea class="form-control" name="description" id="description" placeholder="Enter Description" rows="4"
                                                    maxlength="500" autocomplete="off">{{ $data->description }}</textarea>
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
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')


        <script>
            function getEditData(id) {
                var url = "{{ route('MemberProducts.productedit', ':id') }}";
                url = url.replace(":id", id);

                if (id) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            var obj = JSON.parse(data);

                            $("#editproductname").val(obj.product_name);
                            $("#editdescription").val(obj.description);
                            $('#getid').val(obj.memberservices_id);
                            $('#memberid').val(obj.member_id);
                            $("#edit_price_type").val(obj.price_type);
                            if (obj.price_type === 'fixed') {
                                $("#edit_fixed_price_input").show();
                                $("#edit_ranged_price_input").hide();
                                $("#edit_fixed_price").val(obj.price);
                            } else if (obj.price_type === 'ranged') {
                                $("#edit_fixed_price_input").hide();
                                $("#edit_ranged_price_input").show();
                                $("#edit_min_price").val(obj.min_price);
                                $("#edit_max_price").val(obj.max_price);
                            }
                        }
                    });
                }
            }
            $("#edit_price_type").on("change", function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'fixed') {
                    $("#edit_fixed_price_input").show();
                    $("#edit_ranged_price_input").hide();
                } else if (selectedValue === 'ranged') {
                    $("#edit_fixed_price_input").hide();
                    $("#edit_ranged_price_input").show();
                }
            });
        </script>


        <script>
            function deleteData(id) {
                $("#deleteid").val(id);
            }
        </script>

        <script>
            function chkname() {
                var name = $('#companyname').val();
                var url = "{{ route('members.checkserviceprovider') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        name,
                        name
                    },
                    success: function(data) {
                        console.log(data);
                        var obj = JSON.parse(data);
                        if (data == 1) {

                            alert('Members Already Exist');
                            $('#companyname').val('');
                            $('#companyname').focus();
                            return false;

                        }
                    }
                });
            }
        </script>
        <script>
            function editchkname() {
                var name = $('#Editname').val();
                var url = "{{ route('members.editcheckserviceprovider') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        name,
                        name
                    },
                    success: function(data) {
                        console.log(data);
                        var obj = JSON.parse(data);
                        if (data == 1) {

                            alert('Members Already Exist');
                            $('#Editname').val('');
                            $('#Editname').focus();
                            return false;

                        }
                    }
                });
            }
        </script>

        {{-- city based display group --}}
        <script>
            function updateCityGroups() {
                var city_id = $("#city_id").val();
                var url = "{{ route('members.cityid', ':city_id') }}";
                url = url.replace(":city_id", city_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        city_id: city_id,
                    },
                    success: function(data) {
                        $("#citygroup_id").html('');
                        $("#citygroup_id").append(data);
                    }
                });
            }
        </script>


        <script>
            function updatesubcategories() {
                var categories_id = $("#category_id").val();
                var url = "{{ route('members.categoryid', ':category_id') }}";
                url = url.replace(":category_id", categories_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        category_id: categories_id,
                    },
                    success: function(data) {
                        $("#subcategories_id").html('');
                        $("#subcategories_id").append(data);
                    }
                });
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var editPriceTypeSelect = document.getElementById("edit_price_type");
                var editFixedPriceInput = document.getElementById("edit_fixed_price_input");
                var editRangedPriceInput = document.getElementById("edit_ranged_price_input");

                // Set initial display state based on the default value of Price Type
                if (editPriceTypeSelect.value === "fixed") {
                    editFixedPriceInput.style.display = "block";
                    editRangedPriceInput.style.display = "none";
                } else if (editPriceTypeSelect.value === "ranged") {
                    editFixedPriceInput.style.display = "none";
                    editRangedPriceInput.style.display = "block";
                }

                editPriceTypeSelect.addEventListener("change", function() {
                    if (editPriceTypeSelect.value === "fixed") {
                        editFixedPriceInput.style.display = "block";
                        editRangedPriceInput.style.display = "none";
                    } else if (editPriceTypeSelect.value === "ranged") {
                        editFixedPriceInput.style.display = "none";
                        editRangedPriceInput.style.display = "block";
                    }
                });
            });
        </script>
        <script>
            $(window).on('load', function() {
                $('#editdescription').ckeditor();
            });
        </script>
        <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
        <script type="text/javascript">
            // Initialize NicEdit for specific textareas by their IDs
            bkLib.onDomLoaded(function() {
                new nicEditor({
                    fullPanel: true
                }).panelInstance('description'); // For description textarea
            });
        </script>
        <script>
            function cancelForm() {
                window.location.reload();
            }
        </script>

    @endsection
