@extends('layouts.app')
@section('title', 'Events List')
@section('content')
    <style>
        #EditModal .nicEdit-panelContain {
            width: 100% !important;
            box-sizing: border-box !important;
        }

        #EditModal .nicEdit-main {
            width: auto !important;
            min-height: 180px !important;
            padding: 10px !important;
            box-sizing: border-box !important;
        }

        #EditModal .nicEdit-main:focus {
            outline: none;
        }

        #Edit_assign_members {
            min-height: 160px;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                {{-- Alert Messages --}}
                @include('common.alert')
                {{-- Tab start  --}}
                <!--<div class="col-lg-12">-->
                <!--    <div class="card">-->
                <!--        <div class="card-body">-->
                <!--            <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-success mb-3" role="tablist">-->
                <!--                <li class="nav-item" role="presentation">-->
                <!--                    <a class="nav-link active" href="{{ route('Event.index') }}">-->
                <!--                        <i class="fas fa-clock"></i> Pending-->
                <!--                    </a>-->
                <!--                </li>-->

                <!--                <li class="nav-item" role="presentation">-->
                <!--                    <a class="nav-link" href="{{ route('Event.approvelist') }}" role="tab"-->
                <!--                        aria-selected="false" tabindex="-1">-->
                <!--                        <i class="fas fa-check-circle"></i> Approved-->
                <!--                    </a>-->
                <!--                </li>-->
                <!--                <li class="nav-item" role="presentation">-->
                <!--                    <a class="nav-link" href="{{ route('Event.removelist') }}" role="tab"-->
                <!--                        aria-selected="false" tabindex="-1">-->
                <!--                        <i class="fas fa-times-circle"></i>Rejected-->
                <!--                    </a>-->
                <!--                </li>-->
                <!--            </ul>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                {{-- Tab End  --}}

                {{-- start search  --}}
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <form method="post" id="form" action="{{ route('Event.index') }}">
                                @csrf
                                <div class="row align-items-center">

                                    {{-- <div class="col-md-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <select class="form-select select2" id="given_by" name="given_by" data-choices
                                                name="Contact_person">
                                                <option value="">Select Member</option>
                                                @foreach ($members as $businesses1)
                                                    <option value="{{ $businesses1->user_id }}"
                                                        {{ isset($givenby) && $businesses1->user_id == $givenby ? 'selected' : '' }}>
                                                        {{ $businesses1->Contact_person }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}

                                    <!-- new search add -->
                                    <div class="col-md-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter From Date" type="text" class="form-control"
                                                id="startdatepicker" name="fromdate" autocomplete="off"
                                                value="<?= isset($FromDate) ? $FromDate : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter To Date" type="text" class="form-control "
                                                name="todate" autocomplete="off" id="enddatepicker"
                                                value="<?= isset($ToDate) ? $ToDate : '' ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex align-items-center ">
                                            <div class="input-group d-flex ">
                                                <input type="submit" id="search" class="btn btn-success mx-2"
                                                    name="search" title="Search" value="Search">
                                                <button type="button" id="cancel_search"
                                                    class="btn btn-success">Cancel</button>
                                            </div>
                                            <button class="btn btn-success" type="button" onclick="exportExcel();">
                                                <i class="fa-solid fa-file-excel fa-xl"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end search --}}

                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Events List
                                    </h5>
                                </div>
                                <div>
                                    <a href="{{ route('Event.storeview') }}" class="btn btn-success">Add Events</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                    aria-labelledby="tab-dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540"
                                    id="dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540">
                                    <div id="tableExample" data-list='{"valueNames":["name","email","age"]}'>
                                        <div class="table-responsive scrollbar">
                                            <table class="table table-bordered table-striped fs--1 mb-0">
                                                <thead class="bg-200 text-900">
                                                    <tr>
                                                        <th width="2%" data-sort="Title">Sr No</th>
                                                        <th width="2%" data-sort="Title">Events Name</th>
                                                        <th width="2%" data-sort="Title">Photo</th>
                                                        <th width="5%" data-sort="Date">Events Date</th>
                                                        <th width="5%" data-sort="Date">Events Start Time</th>
                                                        <th width="5%" data-sort="Date">Events End Time</th>
                                                        <th width="5%" data-sort="Date">Type</th>
                                                        <th width="15%">Assigned Members</th> {{-- New Column --}}
                                                        <th width="5%" data-sort="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    <?php $i = 1; ?>
                                                    @foreach ($Events as $Event)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $Events->perPage() * ($Events->currentPage() - 1) }}
                                                            </td>
                                                            <td class="text-center">{{ $Event->name }}</td>
                                                            <td class="text-center">
                                                                <img src="{{ asset('/event') . '/' . $Event->photo }}"
                                                                    style="width: 50px;height: 50px;">
                                                            </td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($Event->eventstart_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $Event->eventstart_time }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $Event->eventend_time }}
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($Event->event_type == 1)
                                                                    ESP
                                                                @elseif($Event->event_type == 2)
                                                                    Training
                                                                @else
                                                                    Event
                                                                @endif

                                                            </td>
                                                            <td>
                                                                @php
                                                                    $assignedIds = $Event->assign_member_id
                                                                        ? json_decode($Event->assign_member_id, true)
                                                                        : [];
                                                                @endphp

                                                                @if (count($assignedIds) > 0)
                                                                    <div class="assigned-members">
                                                                        @foreach ($assignedIds as $memberId)
                                                                            @php
                                                                                $member = \DB::table('members')
                                                                                    ->select(
                                                                                        'Contact_person',
                                                                                        'phonenumber',
                                                                                    )
                                                                                    ->where('id', $memberId)
                                                                                    ->first();
                                                                            @endphp
                                                                            @if ($member)
                                                                                <div
                                                                                    class="badge bg-soft-primary text-primary mb-1 me-1">
                                                                                    {{ $member->Contact_person ?? '' }}
                                                                                    <br>
                                                                                    {{-- <small>({{ $member->phonenumber }})</small> --}}
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">No members assigned</span>
                                                                @endif
                                                            </td>

                                                            <td class="d-flex gap-2 justify-content-center">
                                                                <a href="{{ route('Event.edit.page', $Event->event_id) }}"
                                                                    title="Edit Event">
                                                                    <span class="text-500 fas fa-edit"></span>
                                                                </a>
                                                                <a class="" href="#" data-bs-toggle="modal"
                                                                    title="Delete" data-bs-target="#deleteRecordModal"
                                                                    onclick="deleteData(<?= $Event->event_id ?>);">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                                {{-- <a class=""
                                                                    href="{{ route('Eventinquiry.index', $Event->event_id) }}"
                                                                    title="Event Inquiry">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                </a> --}}

                                                                <a class=""
                                                                    href="{{ route('Eventinquiry.EventParticipate', $Event->event_id) }}"
                                                                    title="Event Participate">
                                                                    <i class="fa fa-question-circle"
                                                                        aria-hidden="true"></i>
                                                                </a>

                                                            </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">

                                            {{ $Events->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="background-color: white;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Events</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form method="post" action="{{ route('Event.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-body">

                                <input type="hidden" name="event_id" id="event_id" value="">

                                <div class="row">
                                    <div class="form-group">
                                        <span style="color:red;">*</span>Events Name</label>
                                        <input class="form-control" id="Editname" name="name" type="text"
                                            placeholder="Enter Name" value="{{ old('name') }}" required>
                                    </div><br>
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Photo</label>
                                        <input type="file" name="photo" class="form-control" id="Editphoto">
                                        <input type="hidden" name="hiddenPhoto" class="form-control" id="hiddenPhoto">
                                        <div id="PHOTOID">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Events Date
                                        <input type="date" class="form-control" name="eventstart_date"
                                            id="Editeventstart_date" placeholder="Enter Event Start Date"
                                            value="{{ old('eventstart_date') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Events Start Time
                                        <input type="text" class="form-control" name="eventstart_time"
                                            id="Editeventstart_time" placeholder="Enter Event Start Time"
                                            value="{{ old('eventstart_time') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Events End Time
                                        <input type="text" class="form-control" name="eventend_time"
                                            id="Editeventend_time" placeholder="Enter Event End Time"
                                            value="{{ old('eventend_time') }}" required>
                                    </div>
                                    {{-- NEW START --}}
                                    <div class="mb-3">
                                        <span style="color:red;">*</span> Events Type
                                        <select class="form-control" name="event_type" id="Editeventtype"
                                            value="{{ old('event_type') }}" required>
                                            <option value="1" {{ old('event_type') == 1 ? 'selected' : '' }}>ESP
                                            </option>
                                            <option value="2" {{ old('event_type') == 2 ? 'selected' : '' }}>Training
                                            </option>
                                            <option value="3" {{ old('event_type') == 3 ? 'selected' : '' }}>Event
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-12">
                                        <label><span style="color:red;">*</span> Assign Members</label>
                                        <select class="form-control" name="assign_member_id[]" id="Edit_assign_members"
                                            multiple required>

                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}">
                                                    {{ $member->Contact_person }} ({{ $member->phonenumber }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- NEW END  --}}
                                    <div class="mb-3 w-100">
                                        <label for="description">
                                            <span style="color:red;">*</span>Description
                                        </label>
                                        <textarea style="width:100%;" class="form-control" name="description" id="Editdescription"
                                            placeholder="Enter Description" rows="4" maxlength="500" autocomplete="off" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-success">

                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--Delete Modal Start -->
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                        </lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                            Yes,
                            Delete It!
                        </a>
                        <form id="user-delete-form" method="POST" action="{{ route('Event.delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" id="deleteid" value="">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Delete modal End -->
    {{-- @endforeach --}}
@endsection

@section('scripts')
    <script>
        let editNicEditorInitialized = false;
        let pendingEditDescription = '';

        /**
         * Return the NicEdit instance safely.
         */
        function getEditNicEditor() {
            if (
                typeof window.nicEditors === 'undefined' ||
                !editNicEditorInitialized
            ) {
                return null;
            }

            try {
                return nicEditors.findEditor('Editdescription');
            } catch (error) {
                return null;
            }
        }

        /**
         * Fix NicEdit width after opening the Bootstrap modal.
         */
        function fixEditNicEditorWidth() {
            const mainEditor = $('#EditModal .nicEdit-main');

            if (!mainEditor.length) {
                return;
            }

            mainEditor.css({
                width: 'auto',
                minHeight: '180px',
                boxSizing: 'border-box'
            });

            mainEditor.parent().css({
                width: '100%',
                boxSizing: 'border-box'
            });

            mainEditor.parent().parent().css({
                width: '100%',
                boxSizing: 'border-box'
            });

            $('#EditModal .nicEdit-panelContain').css({
                width: '100%',
                boxSizing: 'border-box'
            });
        }

        /**
         * Set content in both textarea and NicEdit.
         */
        function setEditDescription(description) {
            pendingEditDescription = description || '';

            // Set original textarea value.
            $('#Editdescription').val(pendingEditDescription);

            // Set visible NicEdit content.
            const editor = getEditNicEditor();

            if (editor) {
                editor.setContent(pendingEditDescription);
            }
        }

        /**
         * Initialize NicEdit only after modal becomes visible.
         */
        function initializeEditNicEditor() {
            if (!editNicEditorInitialized) {
                new nicEditor({
                    fullPanel: true
                }).panelInstance('Editdescription');

                editNicEditorInitialized = true;
            }

            setTimeout(function() {
                fixEditNicEditorWidth();

                const editor = getEditNicEditor();

                if (editor) {
                    editor.setContent(pendingEditDescription);
                }
            }, 100);
        }

        /**
         * Load event edit data.
         */
        function getEditData(id) {
            const urlTemplate = "{{ route('Event.edit', ':id') }}";
            const url = urlTemplate.replace(':id', id);

            // Clear previous selected members while loading.
            $('#Edit_assign_members').val([]);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',

                success: function(response) {
                    if (response.status === false) {
                        alert(response.message || 'Event data not found.');
                        return;
                    }

                    $('#event_id').val(response.event_id);
                    $('#Editname').val(response.name);
                    $('#Editeventstart_date').val(response.eventstart_date);
                    $('#Editeventstart_time').val(response.eventstart_time);
                    $('#Editeventend_time').val(response.eventend_time);
                    $('#Editeventtype').val(String(response.event_type));
                    $('#hiddenPhoto').val(response.photo || '');

                    /*
                     * Select previously assigned members.
                     * Native multiple select does not need Choices.js.
                     */
                    let selectedMemberIds = response.selected_member_ids || [];

                    selectedMemberIds = selectedMemberIds.map(function(id) {
                        return String(id);
                    });

                    $('#Edit_assign_members')
                        .val(selectedMemberIds)
                        .trigger('change');

                    /*
                     * Update NicEdit content.
                     */
                    setEditDescription(response.description);

                    /*
                     * Display current event photo.
                     */
                    if (response.photo) {
                        const imageUrl = "{{ asset('event') }}/" + response.photo;

                        $('#PHOTOID').html(
                            '<img src="' + imageUrl + '"' +
                            ' alt="Event Photo"' +
                            ' width="80"' +
                            ' height="80"' +
                            ' style="object-fit:cover; margin-top:10px;">'
                        );
                    } else {
                        $('#PHOTOID').html('');
                    }
                },

                error: function(xhr) {
                    console.error(xhr.responseText);

                    alert(
                        xhr.responseJSON?.message ||
                        'Unable to load event details.'
                    );
                }
            });
        }

        $(document).ready(function() {
            /*
             * Initialize NicEdit only when modal has a real visible width.
             */
            $('#EditModal').on('shown.bs.modal', function() {
                initializeEditNicEditor();
            });

            /*
             * Synchronize NicEdit HTML into textarea before submission.
             */
            $('#EditModal form').on('submit', function() {
                const editor = getEditNicEditor();

                if (editor) {
                    editor.saveContent();
                }
            });

            /*
             * Clear old values when modal closes.
             */
            $('#EditModal').on('hidden.bs.modal', function() {
                $('#Edit_assign_members').val([]);
                $('#Editphoto').val('');
                $('#PHOTOID').html('');
                setEditDescription('');
            });
        });

        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>

    <script>
        $(document).ready(function() {
            // Add click event listener to the cancel button
            $('#cancel_search').click(function() {
                // Reset the value of the category_id select element to empty
                $('#startdatepicker').val('');
                $('#enddatepicker').val('');
                $('#given_by').val('');
                $('#form').submit();
            });
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#startdatepicker").datepicker({
                dateFormat: 'd-m-yy',
                //minDate: 0
            });

            $("#enddatepicker").datepicker({
                dateFormat: 'd-m-yy',
                //minDate: 0
            });
        });
    </script>

    <script>
        function exportExcel() {
            // alert('hello');
            var fromdate = $("#startdatepicker").val();
            var todate = $("#enddatepicker").val();
            // var first_name = $("#first_name").val();

            var strURL = "{{ route('Event.exportevent') }}";
            strURL += "/" + fromdate + "/" + todate;

            window.location.href = strURL;
        }
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
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>
@endsection
