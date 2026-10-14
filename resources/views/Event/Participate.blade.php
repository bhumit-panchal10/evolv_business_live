@extends('layouts.app')
@section('title', 'Participants Events List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                {{-- Alert Messages --}}

                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row flex-between-end">
                                <div class="col-auto align-self-center">
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Events List
                                    </h5>
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
                                                        <th width="2%" data-sort="Title">Member</th>
                                                        <th width="2%" data-sort="Title">Status</th>
                                                        <th width="2%" data-sort="Title">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    <?php $i = 1; ?>
                                                    @foreach ($Events as $Event)
                                                        @foreach ($Event->EventMembers as $memberData)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                                <td class="text-center">{{ $Event->name }}</td>

                                                                <td class="text-center">
                                                                    <img src="{{ asset('event') . '/' . $Event->photo }}"
                                                                        style="width:50px;height:50px;">
                                                                </td>

                                                                <td class="text-center">
                                                                    {{ \Carbon\Carbon::parse($Event->eventstart_date)->format('d-m-Y') }}
                                                                </td>

                                                                <td class="text-center">{{ $Event->eventstart_time }}</td>
                                                                <td class="text-center">{{ $Event->eventend_time }}</td>

                                                                <td class="text-center">
                                                                    {{ $Event->event_type == 1 ? 'ESP' : 'Training' }}
                                                                </td>

                                                                {{-- 🔥 MEMBER NAME --}}
                                                                <td class="text-center">
                                                                    {{ $memberData->member->Contact_person ?? '' }}
                                                                </td>

                                                                {{-- 🔥 STATUS --}}
                                                                <td class="text-center">
                                                                    @if ($memberData->absent == 1)
                                                                        Absent
                                                                    @elseif($memberData->isapproved_status == 1)
                                                                        Join
                                                                    @elseif($memberData->isapproved_status == 0)
                                                                        Pending
                                                                    @elseif($memberData->isapproved_status == 2)
                                                                        Not Join
                                                                    @else
                                                                        Not Join
                                                                    @endif
                                                                </td>
                                                               <td class="text-center">
                                                                @php
                                                                    $eventEnd = null;
                                                                
                                                                    $endDate = $Event->eventend_date ?: $Event->eventstart_date;
                                                                
                                                                    $endTime = trim($Event->eventend_time ?? '');
                                                                
                                                                    // 06:pm => 06:00 pm
                                                                    if (preg_match('/^(\d{1,2}):(am|pm)$/i', $endTime)) {
                                                                        $endTime = preg_replace('/:(am|pm)$/i', ':00 $1', $endTime);
                                                                    }
                                                                
                                                                    if ($endDate && $endTime) {
                                                                        $eventEnd = \Carbon\Carbon::parse($endDate.' '.$endTime);
                                                                    }
                                                                @endphp
                                                            
                                                                @if ($eventEnd && $eventEnd->isPast())
                                                                    <button type="button"
                                                                        class="btn btn-link p-0 text-primary"
                                                                        title="Update attendance" data-bs-toggle="modal"
                                                                        data-bs-target="#eventMemberStatusModal"
                                                                        data-member-id="{{ $memberData->id }}"
                                                                        data-current-absent="{{ $memberData->absent ?? 0 }}">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                @endif
                                                            </td>

                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <div class="d-flex justify-content-center mt-3">

                                            {{ $Events->links() }}
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="eventMemberStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('Eventinquiry.memberstatus.update') }}">
                    @csrf
                    <input type="hidden" name="event_member_id" id="eventMemberId">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Attendance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="absentSelect" class="form-label">Attendance Status</label>
                            <select name="absent" id="absentSelect" class="form-select">
                                <option value="0">Join</option>
                                <option value="1">Absent</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- @endforeach --}}
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('eventMemberStatusModal');
            if (!modal) {
                return;
            }

            modal.addEventListener('show.bs.modal', function(event) {
                const triggerButton = event.relatedTarget;
                const memberId = triggerButton.getAttribute('data-member-id');
                const currentAbsent = triggerButton.getAttribute('data-current-absent');

                document.getElementById('eventMemberId').value = memberId || '';
                document.getElementById('absentSelect').value = currentAbsent === '1' ? '1' : '0';
            });
        });
    </script>
@endsection
