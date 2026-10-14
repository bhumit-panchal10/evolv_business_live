@extends('layouts.app')
@section('title', 'Events')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        .assign-member-box {
            position: relative !important;
            overflow: visible !important;
        }

        .assign-member-box .choices {
            width: 100% !important;
            margin-bottom: 0 !important;
            position: relative !important;
            overflow: visible !important;
            z-index: 9999 !important;
        }

        .assign-member-box .choices.is-open {
            z-index: 999999 !important;
        }

        .assign-member-box .choices__inner {
            min-height: 45px !important;
            padding: 8px 12px !important;
            background: #fff !important;
            border: 1px solid #ced4da !important;
            border-radius: 4px !important;
            overflow: hidden !important;
        }

        .assign-member-box .choices__list--dropdown,
        .assign-member-box .choices__list[aria-expanded] {
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            right: auto !important;
            width: 100% !important;
            min-width: 100% !important;
            max-height: 250px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            background: #fff !important;
            border: 1px solid #ced4da !important;
            z-index: 999999 !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15) !important;
        }

        .assign-member-box .choices__list--dropdown .choices__item,
        .assign-member-box .choices__list[aria-expanded] .choices__item {
            padding: 10px 15px !important;
            margin: 0 !important;
            width: 100% !important;
            display: block !important;
            white-space: normal !important;
            word-break: normal !important;
            overflow: visible !important;
            text-indent: 0 !important;
            line-height: 20px !important;
            color: #212529 !important;
            box-sizing: border-box !important;
        }

        .assign-member-box .choices__item--choice.is-highlighted {
            background: #f1f1f1 !important;
        }

        .card,
        .card-body,
        .live-preview,
        form,
        .row,
        .container-fluid {
            overflow: visible !important;
        }

        /* ==========================================
               ADD EVENT - MEMBER SEARCH
            ========================================== */

        .assign-member-box {
            max-width: 600px;
        }

        .assign-member-box .choices__inner {
            min-height: 38px !important;
            padding: 4px 8px !important;
        }


        /* Search textbox */

        .assign-member-box .choices__input--cloned {
            display: inline-block !important;

            width: 220px !important;
            max-width: 100% !important;

            margin: 2px 0 !important;
            padding: 5px 7px !important;

            border: 1px solid #e1e5e9 !important;
            border-radius: 4px !important;

            background: #fff !important;

            font-size: 12px !important;

            box-sizing: border-box !important;
        }

        .assign-member-box .choices__input--cloned::placeholder {
            color: #8d98a3 !important;
        }


        /* Selected member chips */

        .assign-member-box .choices__list--multiple .choices__item {
            margin: 2px 4px 2px 0 !important;
            padding: 4px 7px !important;

            font-size: 11px !important;
        }


        /* Dropdown */

        .assign-member-box .choices__list--dropdown,
        .assign-member-box .choices__list[aria-expanded] {

            max-height: 180px !important;

            overflow-y: auto !important;
            overflow-x: hidden !important;

            padding: 0 !important;
        }


        /* Dropdown member row */

        .assign-member-box .choices__list--dropdown .choices__item,

        .assign-member-box .choices__list[aria-expanded] .choices__item {

            width: 100% !important;

            padding: 8px 12px !important;

            margin: 0 !important;

            text-indent: 0 !important;

            white-space: normal !important;

            font-size: 12px !important;

            line-height: 18px !important;

            box-sizing: border-box !important;
        }

        .assign-member-box .choices__item--choice.is-highlighted {
            background: #f2f7ef !important;
        }

        /* =========================================================
       FIX CHOICES MEMBER NAME LEFT CUT ISSUE
    ========================================================= */

        .assign-member-box .choices__list--dropdown,
        .assign-member-box .choices__list[aria-expanded] {
            padding: 0 !important;
            margin: 0 !important;

            overflow-x: hidden !important;
        }


        /* Inner dropdown list */
        .assign-member-box .choices__list--dropdown .choices__list,
        .assign-member-box .choices__list[aria-expanded] .choices__list {
            padding: 0 !important;
            margin: 0 !important;

            width: 100% !important;

            overflow-x: hidden !important;
        }


        /* Individual member */
        .assign-member-box .choices__list--dropdown .choices__item,
        .assign-member-box .choices__list[aria-expanded] .choices__item {
            position: relative !important;

            left: 0 !important;
            right: auto !important;

            transform: none !important;

            width: 100% !important;

            margin: 0 !important;

            /* IMPORTANT */
            padding: 8px 12px !important;
            padding-left: 15px !important;

            text-indent: 0 !important;

            white-space: normal !important;
            word-break: normal !important;

            overflow: visible !important;

            box-sizing: border-box !important;

            font-size: 12px !important;
            line-height: 18px !important;

            color: #212529 !important;
        }


        /* Choices default pseudo spacing remove */
        .assign-member-box .choices__list--dropdown .choices__item::before,
        .assign-member-box .choices__list--dropdown .choices__item::after,
        .assign-member-box .choices__list[aria-expanded] .choices__item::before,
        .assign-member-box .choices__list[aria-expanded] .choices__item::after {
            margin: 0 !important;
        }


        /* Search box also proper left aligned */
        .assign-member-box .choices__input--cloned {
            margin-left: 0 !important;

            padding-left: 10px !important;

            text-indent: 0 !important;
        }


        /* Selected items */
        .assign-member-box .choices__list--multiple {
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        .assign-member-box .choices__list--multiple .choices__item {
            margin-left: 0 !important;
            text-indent: 0 !important;
        }
    </style>
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
                                <h5 class="card-title mb-0">Add Events</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('Event.create') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-3 mb-3">
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span>Events Name
                                                <input class="form-control" id="basic-form-name" name="name"
                                                    type="text" placeholder="Enter Name" value="{{ old('name') }}"
                                                    required>
                                            </div>
                                            <!-- new -->
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span>Photo
                                                <input class="form-control" type="file" name="photo" id="photovalidate"
                                                    value="{{ old('photo') }}" required>
                                            </div>
                                            <!-- new -->

                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span>Events Date
                                                <input type="date" class="form-control" name="eventstart_date"
                                                    id="" placeholder="Enter Event Start Date"
                                                    value="{{ old('eventstart_date') }}" required>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span>Events Start Time
                                                <input class="form-control" id="basic-form-name" name="eventstart_time"
                                                    type="text" placeholder="Enter Start Time"
                                                    value="{{ old('eventstart_time') }}" required>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span>Events End Time
                                                <input class="form-control" id="basic-form-name" name="eventend_time"
                                                    type="text" placeholder="Enter End Time"
                                                    value="{{ old('eventend_time') }}" required>
                                            </div>
                                            {{-- <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span>Events End Date
                                                <input type="date" class="form-control" name="eventend_date"
                                                    id="" placeholder="Enter Event End Date"
                                                    value="{{ old('eventend_date') }}" required>
                                            </div> --}}
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span>Events Type
                                                <select class="form-control" name="event_type" id="event_type"
                                                    value="{{ old('event_type') }}" required>
                                                    <option value="1">ESP</option>
                                                    <option value="2">Training</option>
                                                    <option value="3">Event</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-6 assign-member-box">
                                                <label for="assign_members">
                                                    <span style="color:red;">*</span> Assign Members
                                                </label>

                                                <select class="form-select" name="assign_member_id[]" id="assign_members"
                                                    multiple required>
                                                    <option value="select_all">Select All</option>
                                                    @foreach ($members as $member)
                                                        <option value="{{ $member->id }}">
                                                            {{ $member->Contact_person }} ({{ $member->phonenumber }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-6" id="priceField" style="display:none;">
                                                <span style="color:red;">*</span> Price
                                                <input type="number" class="form-control" name="price" id="price"
                                                    placeholder="Enter Price" value="{{ old('price') }}">
                                            </div>

                                            <div class="col-lg-4 col-md-6" id="setnumber" style="display:none;">
                                                <span style="color:red;">*</span>Set Number:
                                                <input type="number" class="form-control" name="setnumber" id="setnumber"
                                                    placeholder="Enter setnumber" value="{{ old('setnumber') }}">
                                            </div>
                                            <div>
                                                <span style="color:red;">*</span>Description
                                                <textarea class="form-control" name="description" id="description" placeholder="Enter Description" rows="4"
                                                    maxlength="500" autocomplete="off"></textarea>
                                            </div>
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
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {

        //     const memberSelect = document.getElementById('assign_members');

        //     if (memberSelect) {
        //         const memberChoices = new Choices(memberSelect, {
        //             removeItemButton: true,
        //             itemSelectText: '',
        //             placeholder: true,
        //             placeholderValue: 'Select Members',
        //             searchPlaceholderValue: 'Search members...',
        //             noResultsText: 'No matching members found',
        //             shouldSort: false,
        //             searchEnabled: true,
        //             position: 'auto'
        //         });

        //         memberSelect.addEventListener('change', function() {
        //             const selectedValues = memberChoices.getValue(true);

        //             if (selectedValues.includes('select_all')) {
        //                 const allValues = Array.from(memberSelect.options)
        //                     .filter(option => option.value !== 'select_all')
        //                     .map(option => option.value);

        //                 memberChoices.removeActiveItems();
        //                 memberChoices.setChoiceByValue(allValues);
        //             }
        //         });
        //     }

        //     // const eventType = document.getElementById('event_type');

        //     // if (eventType) {
        //     //     new Choices(eventType, {
        //     //         searchEnabled: false,
        //     //         itemSelectText: '',
        //     //         shouldSort: false
        //     //     });
        //     // }

        // });

        document.addEventListener('DOMContentLoaded', function() {

            const memberSelect =
                document.getElementById('assign_members');


            if (memberSelect) {

                const memberChoices =
                    new Choices(memberSelect, {

                        removeItemButton: true,

                        itemSelectText: '',

                        placeholder: true,

                        placeholderValue: 'Select Members',

                        searchEnabled: true,

                        searchChoices: true,

                        searchFloor: 1,

                        searchPlaceholderValue: 'Search member by name or mobile...',

                        noResultsText: 'No matching members found',

                        noChoicesText: 'No members available',

                        shouldSort: false,

                        position: 'bottom',

                        renderSelectedChoices: 'auto'
                    });


                /* =====================================
                   SELECT ALL
                ===================================== */

                memberSelect.addEventListener(
                    'change',
                    function() {

                        const selectedValues =
                            memberChoices.getValue(true);


                        if (
                            selectedValues.includes(
                                'select_all'
                            )
                        ) {

                            const allValues =
                                Array
                                .from(memberSelect.options)

                                .filter(function(option) {

                                    return option.value !==
                                        'select_all';

                                })

                                .map(function(option) {

                                    return option.value;

                                });


                            memberChoices
                                .removeActiveItems();


                            memberChoices
                                .setChoiceByValue(
                                    allValues
                                );
                        }

                    }
                );
            }

        });
    </script>

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

    <script>
        function EditvalidateFile() {
            //alert('hello');
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
            var fileExtension = document.getElementById('Editphoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;
            var image = document.getElementById('Editphoto').value;
            for (var index in allowedExtension) {
                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (image != "") {
                if (!isValidFile) {
                    alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
                }
                return isValidFile;
            }
            return true;
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
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#viewimg').html(html);
        });
    </script>

    {{-- Edit photo --}}
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
        $("#Editphoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#PHOTOID').html(html);
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#priceField").hide();
            $("#ispaid").change(function() {
                if ($(this).val() === "Yes") {
                    $("#priceField").show();
                } else {
                    $("#priceField").hide();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#setnumber").hide();
            $("#limitedset").change(function() {
                if ($(this).val() === "Yes") {
                    $("#setnumber").show();
                } else {
                    $("#setnumber").hide();
                }
            });
        });
    </script>
    <script>
        $(window).on('load', function() {
            $('#description').ckeditor();
        });
    </script>

    <script type="text/javascript">
        bkLib.onDomLoaded(function() {
            nicEditors.allTextAreas()
        });
    </script>
    <script>
        function cancelForm() {
            window.location.reload();
        }
    </script>
@endsection
