@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        .event-edit-page {
            padding-bottom: 40px;
        }

        .event-section-card {
            border: 1px solid #e8edf2;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 22px;
        }

        .event-section-header {
            padding: 15px 20px;
            background: #f8fafb;
            border-bottom: 1px solid #e8edf2;
        }

        .event-section-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .event-section-header p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #7b8794;
        }

        .event-section-body {
            padding: 20px;
        }

        .current-event-photo {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-top: 8px;
        }

        .member-avatar {
            width: 38px;
            height: 38px;
            min-width: 38px;
            border-radius: 50%;
            background: #edf7f2;
            color: #198754;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 600;
        }

        .member-status {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .member-status.pending {
            background: #fff4d8;
            color: #aa7500;
        }

        .member-status.approved {
            background: #e3f7ea;
            color: #198754;
        }

        .member-status.rejected {
            background: #fde8e8;
            color: #dc3545;
        }



        /* =========================================================
                               EDIT PAGE - ASSIGN MEMBERS
                            ========================================================= */

        .edit-assign-member-box {
            position: relative !important;
            overflow: visible !important;

            /* box ki overall width */
            max-width: 650px;
        }


        /* MAIN CHOICES WRAPPER */

        .edit-assign-member-box .choices {
            width: 100% !important;

            margin: 0 !important;

            position: relative !important;

            z-index: 100 !important;
        }


        /* MAIN SELECT BOX - SMALLER */

        .edit-assign-member-box .choices__inner {
            width: 100% !important;

            min-height: 38px !important;

            padding: 4px 8px !important;

            background: #fff !important;

            border: 1px solid #ced4da !important;

            border-radius: 4px !important;

            box-sizing: border-box !important;
        }


        /* ==========================================
                               SEARCH INPUT
                            ========================================== */

        .edit-assign-member-box .choices__input--cloned {
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

        .edit-assign-member-box .choices__input--cloned::placeholder {
            color: #8d98a3 !important;
        }


        /* ==========================================
                               SELECTED MEMBER CHIPS
                            ========================================== */

        .edit-assign-member-box .choices__list--multiple .choices__item {

            margin: 2px 4px 2px 0 !important;

            padding: 4px 7px !important;

            font-size: 11px !important;

            line-height: 16px !important;
        }


        /* ==========================================
                               DROPDOWN
                            ========================================== */

        .edit-assign-member-box .choices__list--dropdown,

        .edit-assign-member-box .choices__list[aria-expanded] {

            position: absolute !important;

            top: calc(100% + 2px) !important;

            left: 0 !important;

            right: auto !important;

            width: 100% !important;

            min-width: 100% !important;

            max-height: 180px !important;

            overflow-y: auto !important;

            overflow-x: hidden !important;

            padding: 0 !important;

            margin: 0 !important;

            background: #fff !important;

            border: 1px solid #ced4da !important;

            border-radius: 4px !important;

            box-shadow: 0 4px 12px rgba(0, 0, 0, .12) !important;

            z-index: 999999 !important;

            box-sizing: border-box !important;
        }


        /* ==========================================
                               DROPDOWN INNER LIST
                            ========================================== */

        .edit-assign-member-box .choices__list--dropdown .choices__list,

        .edit-assign-member-box .choices__list[aria-expanded] .choices__list {

            padding: 0 !important;

            margin: 0 !important;

            max-height: 175px !important;

            overflow-y: auto !important;

            overflow-x: hidden !important;
        }


        /* ==========================================
                               MEMBER ROW - FIX LEFT SIDE CUTTING
                            ========================================== */

        .edit-assign-member-box .choices__list--dropdown .choices__item,

        .edit-assign-member-box .choices__list[aria-expanded] .choices__item {

            display: block !important;

            width: 100% !important;

            margin: 0 !important;

            padding: 8px 12px !important;

            padding-left: 12px !important;

            text-indent: 0 !important;

            transform: none !important;

            left: 0 !important;

            white-space: normal !important;

            word-break: normal !important;

            overflow: visible !important;

            color: #212529 !important;

            font-size: 12px !important;

            line-height: 18px !important;

            box-sizing: border-box !important;

            border-bottom: 1px solid #f0f0f0;
        }


        .edit-assign-member-box .choices__item--choice.is-highlighted {

            background: #f2f7ef !important;
        }


        /* OPEN STATE */

        .edit-assign-member-box .choices.is-open {

            z-index: 999999 !important;
        }

        /* ==========================================
                   ADD MEMBER DROPDOWN OUTSIDE CARD
                ========================================== */

        .add-member-card {
            overflow: visible !important;
            position: relative !important;
            z-index: 50 !important;
        }

        .add-member-card .event-section-body {
            overflow: visible !important;
            position: relative !important;
        }

        .add-member-card form {
            overflow: visible !important;
        }

        .edit-assign-member-box {
            position: relative !important;
            overflow: visible !important;
            z-index: 1000 !important;
        }

        .edit-assign-member-box .choices {
            position: relative !important;
            overflow: visible !important;
            z-index: 1000 !important;
        }

        .edit-assign-member-box .choices.is-open {
            z-index: 999999 !important;
        }

        .edit-assign-member-box .choices__list--dropdown,
        .edit-assign-member-box .choices__list[aria-expanded] {
            position: absolute !important;

            top: calc(100% + 2px) !important;
            left: 0 !important;

            width: 100% !important;

            max-height: 180px !important;

            overflow-y: auto !important;

            background: #fff !important;

            border: 1px solid #ced4da !important;

            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15) !important;

            z-index: 999999 !important;
        }

        .add-member-card+.event-section-card {
            position: relative;
            z-index: 1;
        }
    </style>


    <div class="main-content">

        <div class="page-content">

            <div class="container-fluid event-edit-page">


                {{-- Alert --}}
                @include('common.alert')


                {{-- ==========================================
                 PAGE HEADER
            =========================================== --}}

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <h4 class="mb-1">
                            Edit Event
                        </h4>

                        <p class="text-muted mb-0">
                            {{ $event->name }}
                        </p>

                    </div>


                    <a href="{{ route('Event.index') }}" class="btn btn-light">
                        <i class="fa fa-arrow-left me-1"></i>
                        Back
                    </a>

                </div>



                {{-- =====================================================
                 SECTION 1
                 EVENT DETAILS
            ====================================================== --}}

                <div class="card event-section-card">

                    <div class="event-section-header">

                        <h5>
                            <i class="fa fa-calendar me-1"></i>
                            Event Details
                        </h5>

                        <p>
                            Update event information without changing assigned members.
                        </p>

                    </div>


                    <div class="event-section-body">

                        <form method="POST" id="editEventDetailsForm" action="{{ route('Event.update.details') }}"
                            enctype="multipart/form-data">

                            @csrf


                            <input type="hidden" name="event_id" value="{{ $event->event_id }}">


                            <div class="row">


                                {{-- Event Name --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        <span class="text-danger">*</span>
                                        Event Name

                                    </label>


                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $event->name) }}" required>

                                </div>



                                {{-- Event Type --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        <span class="text-danger">*</span>
                                        Event Type

                                    </label>


                                    <select name="event_type" class="form-select" required>

                                        <option value="1"
                                            {{ old('event_type', $event->event_type) == 1 ? 'selected' : '' }}>
                                            ESP
                                        </option>

                                        <option value="2"
                                            {{ old('event_type', $event->event_type) == 2 ? 'selected' : '' }}>
                                            Training
                                        </option>

                                        <option value="3"
                                            {{ old('event_type', $event->event_type) == 3 ? 'selected' : '' }}>
                                            Event
                                        </option>

                                    </select>

                                </div>



                                {{-- Date --}}

                                <div class="col-md-4 mb-3">

                                    <label class="form-label">

                                        <span class="text-danger">*</span>
                                        Event Date

                                    </label>


                                    <input type="date" class="form-control" name="eventstart_date"
                                        value="{{ old('eventstart_date', \Carbon\Carbon::parse($event->eventstart_date)->format('Y-m-d')) }}"
                                        required>

                                </div>



                                {{-- Start Time --}}

                                <div class="col-md-4 mb-3">

                                    <label class="form-label">

                                        <span class="text-danger">*</span>
                                        Start Time

                                    </label>


                                    <input type="text" class="form-control" name="eventstart_time"
                                        value="{{ old('eventstart_time', $event->eventstart_time) }}" required>

                                </div>



                                {{-- End Time --}}

                                <div class="col-md-4 mb-3">

                                    <label class="form-label">

                                        <span class="text-danger">*</span>
                                        End Time

                                    </label>


                                    <input type="text" class="form-control" name="eventend_time"
                                        value="{{ old('eventend_time', $event->eventend_time) }}" required>

                                </div>



                                {{-- Photo --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Event Photo
                                    </label>


                                    <input type="file" name="photo" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp">


                                    @if (!empty($event->photo))
                                        <img src="{{ asset('event/' . $event->photo) }}" class="current-event-photo"
                                            alt="Event Photo">
                                    @endif

                                </div>



                                {{-- Description --}}

                                <div class="col-md-12 mb-3 edit-description-box">

                                    <label class="form-label">

                                        <span class="text-danger">*</span>
                                        Description

                                    </label>

                                    <textarea name="description" id="edit_event_description" class="form-control" rows="5" maxlength="500"
                                        autocomplete="off" required>{{ old('description', $event->description) }}</textarea>

                                </div>


                            </div>


                            <button type="submit" class="btn btn-success">

                                <i class="fa fa-save me-1"></i>

                                Update Event

                            </button>


                        </form>

                    </div>

                </div>



                {{-- =====================================================
                 SECTION 2
                 ADD MEMBERS
            ====================================================== --}}

                <div class="card event-section-card add-member-card">

                    <div class="event-section-header">

                        <h5>
                            <i class="fa fa-user-plus me-1"></i>
                            Add Members
                        </h5>

                        <p>
                            Add additional members to this event.
                        </p>

                    </div>


                    <div class="event-section-body">


                        @if ($availableMembers->count() > 0)

                            <form method="POST" id="addEventMembersForm"
                                action="{{ route('Event.add.members', $event->event_id) }}">

                                @csrf


                                <div class="mb-3 edit-assign-member-box">

                                    <label class="form-label" for="edit_assign_members">

                                        <span class="text-danger">*</span>
                                        Select Members

                                    </label>


                                    <select class="form-select" name="member_ids[]" id="edit_assign_members" multiple
                                        required>

                                        <option value="select_all">
                                            Select All
                                        </option>


                                        @foreach ($availableMembers as $member)
                                            <option value="{{ $member->id }}">

                                                {{ $member->Contact_person }}

                                                @if (!empty($member->phonenumber))
                                                    ({{ $member->phonenumber }})
                                                @endif

                                            </option>
                                        @endforeach

                                    </select>

                                </div>


                                <button type="submit" class="btn btn-success">

                                    <i class="fa fa-plus me-1"></i>

                                    Add Selected Members

                                </button>

                            </form>
                        @else
                            <div class="alert alert-info mb-0">

                                All available members are already assigned to this event.

                            </div>

                        @endif


                    </div>

                </div>



                {{-- =====================================================
                 SECTION 3
                 ASSIGNED MEMBERS
            ====================================================== --}}

                <div class="card event-section-card">

                    <div class="event-section-header">

                        <h5>
                            <i class="fa fa-users me-1"></i>
                            Assigned Members
                        </h5>

                        <p>
                            Pending members can be removed. Approved or rejected members are locked.
                        </p>

                    </div>


                    <div class="event-section-body p-0">


                        <div class="table-responsive">


                            <table class="table table-bordered mb-0">

                                <thead class="bg-light">

                                    <tr>

                                        <th width="6%">
                                            #
                                        </th>

                                        <th>
                                            Member
                                        </th>

                                        <th>
                                            Mobile
                                        </th>

                                        <th width="15%">
                                            Status
                                        </th>

                                        <th width="12%" class="text-center">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>


                                    @forelse ($event->EventMembers as $eventMember)
                                        <tr>


                                            <td>

                                                {{ $loop->iteration }}

                                            </td>



                                            <td>

                                                <div class="d-flex align-items-center gap-2">


                                                    <div class="member-avatar">

                                                        {{ strtoupper(substr($eventMember->member->Contact_person ?? 'M', 0, 1)) }}

                                                    </div>


                                                    <div>

                                                        <strong>

                                                            {{ $eventMember->member->Contact_person ?? '-' }}

                                                        </strong>


                                                        @if (!empty($eventMember->member->email))
                                                            <div class="small text-muted">

                                                                {{ $eventMember->member->email }}

                                                            </div>
                                                        @endif

                                                    </div>


                                                </div>

                                            </td>



                                            <td>

                                                {{ $eventMember->member->phonenumber ?? '-' }}

                                            </td>



                                            <td>


                                                @if ((int) $eventMember->isapproved_status === 0)
                                                    <span class="member-status pending">

                                                        Pending

                                                    </span>
                                                @elseif ((int) $eventMember->isapproved_status === 1)
                                                    <span class="member-status approved">

                                                        Approved

                                                    </span>
                                                @else
                                                    <span class="member-status rejected">

                                                        Rejected

                                                    </span>
                                                @endif


                                            </td>



                                            <td class="text-center">


                                                {{-- Only Pending Member Delete --}}

                                                @if ((int) $eventMember->isapproved_status === 0)
                                                    <form method="POST"
                                                        action="{{ route('Event.member.delete', [$event->event_id, $eventMember->id]) }}"
                                                        onsubmit="return confirm('Are you sure you want to remove this member?');">

                                                        @csrf

                                                        @method('DELETE')


                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            title="Delete">

                                                            <i class="fa fa-trash"></i>

                                                        </button>

                                                    </form>
                                                @else
                                                    <span class="text-muted"
                                                        title="Approved/Rejected member cannot be removed">

                                                        <i class="fa fa-lock"></i>

                                                    </span>
                                                @endif


                                            </td>


                                        </tr>


                                    @empty


                                        <tr>

                                            <td colspan="5" class="text-center py-4 text-muted">

                                                No members assigned to this event.

                                            </td>

                                        </tr>
                                    @endforelse


                                </tbody>

                            </table>


                        </div>


                    </div>

                </div>


            </div>

        </div>

    </div>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {


                /* =========================================================
                   ASSIGN MEMBERS - CHOICES JS
                ========================================================= */

                const memberSelect =
                    document.getElementById(
                        'edit_assign_members'
                    );


                if (memberSelect) {

                    const memberChoices = new Choices(memberSelect, {

                        removeItemButton: true,

                        itemSelectText: '',

                        placeholder: true,

                        placeholderValue: 'Select Members',

                        searchEnabled: true,

                        searchChoices: true,

                        searchFloor: 1,

                        searchPlaceholderValue: 'Search member...',

                        noResultsText: 'No matching members found',

                        noChoicesText: 'No members available',

                        shouldSort: false,

                        position: 'bottom',

                        renderSelectedChoices: 'auto'

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | SELECT ALL
                    |--------------------------------------------------------------------------
                    */

                    memberSelect.addEventListener(
                        'change',
                        function() {

                            const selectedValues =
                                memberChoices
                                .getValue(true);


                            if (
                                selectedValues.includes(
                                    'select_all'
                                )
                            ) {

                                const allValues =
                                    Array
                                    .from(
                                        memberSelect.options
                                    )
                                    .filter(
                                        option =>
                                        option.value !==
                                        'select_all'
                                    )
                                    .map(
                                        option =>
                                        option.value
                                    );


                                /*
                                 * Remove Select All itself
                                 */
                                memberChoices
                                    .removeActiveItems();


                                /*
                                 * Select every available member
                                 */
                                memberChoices
                                    .setChoiceByValue(
                                        allValues
                                    );

                            }

                        }
                    );

                }

            }
        );
    </script>
    <script>
        let editEventNicEditor = null;


        bkLib.onDomLoaded(function() {

            /*
            |--------------------------------------------------------------------------
            | Initialize only event description
            |--------------------------------------------------------------------------
            */

            new nicEditor({

                fullPanel: true

            }).panelInstance(
                'edit_event_description'
            );


            /*
             * Find instance after initialization
             */
            try {

                editEventNicEditor =
                    nicEditors.findEditor(
                        'edit_event_description'
                    );

            } catch (error) {

                editEventNicEditor = null;

            }

        });
    </script>
    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const eventForm =
                    document.getElementById(
                        'editEventDetailsForm'
                    );


                if (!eventForm) {
                    return;
                }


                eventForm.addEventListener(
                    'submit',
                    function() {

                        try {

                            const editor =
                                nicEditors.findEditor(
                                    'edit_event_description'
                                );


                            if (editor) {

                                editor.saveContent();

                            }

                        } catch (error) {

                            console.log(
                                'NicEdit save error:',
                                error
                            );

                        }

                    }
                );

            }
        );
    </script>
@endsection
