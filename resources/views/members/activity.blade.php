@extends('layouts.app')
@section('title', 'Member Activity')
@section('content')
    <style>
        .activity-card {
            cursor: pointer;
            border: 1px solid #e9ebec;
            transition: all 0.2s ease-in-out;
        }

        .activity-card.active {
            border-color: #198754;
            background-color: #eaf7ef;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @include('common.alert')

                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1">Member Activity Details</h5>
                            <p class="mb-0">
                                <strong>{{ $member->first_name }}</strong>
                                @if (!empty($member->companyname))
                                    ({{ $member->companyname }})
                                @endif
                                @if (!empty($member->email))
                                    - {{ $member->email }}
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('members.index') }}" class="btn btn-success">Back to Members</a>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <form method="get" action="{{ route('members.activity', $member->id) }}"
                            class="row gy-3 gx-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" class="form-control"
                                    value="{{ $fromDate ? date('Y-m-d', strtotime($fromDate)) : '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" class="form-control"
                                    value="{{ $toDate ? date('Y-m-d', strtotime($toDate)) : '' }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('members.activity', $member->id) }}"
                                    class="btn btn-outline-secondary ms-2">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card activity-card active" data-target="direct-business-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">Direct Business Amount</h6>
                                <h4 class="mb-0">{{ number_format($directBusinessTotal, 0) }}</h4>
                                {{-- <small>Total: ₹{{ number_format($directBusinessTotal, 0) }}</small> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card activity-card" data-target="reference-business-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">Reference Business</h6>
                                <h4 class="mb-0">{{ number_format($referenceBusinessTotal, 0) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card activity-card" data-target="reference-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">Reference List</h6>
                                <h4 class="mb-0">{{ $references->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card activity-card" data-target="member-meetings-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">Member Meeting Count</h6>
                                <h4 class="mb-0">{{ $memberMeetingCount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card activity-card" data-target="member-points-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">Member Point Count</h6>
                                <h4 class="mb-0">{{ $memberPointCount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card activity-card" data-target="visitors-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">Visitors Created</h6>
                                <h4 class="mb-0">{{ $visitors->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="card activity-card" data-target="events-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">Events Created</h6>
                                <h4 class="mb-0">{{ $events->count() }}</h4>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="card activity-card" data-target="attended-events-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">Events Attended</h6>
                                <h4 class="mb-0">{{ $attendedEvents->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card activity-card" data-target="one-to-one-section">
                            <div class="card-body text-center">
                                <h6 class="mb-1">One To One Records</h6>
                                <h4 class="mb-0">{{ $oneToOnes->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $formatApprovalStatus = function ($status) {
                        if ((int) $status === 1) {
                            return 'Approved';
                        }
                        if ((int) $status === 2) {
                            return 'Rejected';
                        }
                        return 'Pending';
                    };
                @endphp

                <div class="card mb-3 activity-section" id="direct-business-section">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Direct Business List</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>To</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($directBusinesses as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->business_to ?? '-' }}</td>
                                        <td>{{ $item->Business_amount ?? '-' }}</td>
                                        <td>{{ !empty($item->business_Date) ? date('d-m-Y', strtotime($item->business_Date)) : '-' }}
                                        </td>
                                        <td>{{ $formatApprovalStatus($item->isapproved_status ?? 0) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No direct business found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3 activity-section d-none" id="reference-business-section">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Reference Business List</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>To</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referenceBusinesses as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->business_to ?? '-' }}</td>
                                        <td>{{ $item->Business_amount ?? '-' }}</td>
                                        <td>{{ !empty($item->business_Date) ? date('d-m-Y', strtotime($item->business_Date)) : '-' }}
                                        </td>
                                        <td>{{ $formatApprovalStatus($item->isapproved_status ?? 0) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No reference business found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3 activity-section d-none" id="reference-section">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Reference List</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reference Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($references as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->Reference_Name ?? '-' }}</td>
                                        <td>{{ $item->Company_Name ?? '-' }}</td>
                                        <td>{{ $item->Email ?? '-' }}</td>
                                        <td>{{ $item->phonenumber ?? '-' }}</td>
                                        <td>{{ !empty($item->Reference_Date) ? date('d-m-Y', strtotime($item->Reference_Date)) : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No references found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3 activity-section d-none" id="member-meetings-section">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Member Meeting History</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Meeting Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Substitute Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($memberMeetings as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->Meeting_title ?? '-' }}</td>
                                        <td>{{ !empty($item->start_date) ? $item->start_date : '-' }}</td>
                                        <td>{{ !empty($item->End_date) ? $item->End_date : '-' }}</td>
                                        <td>
                                            @if ($item->is_approve_meeting == 1)
                                                Join
                                            @elseif($item->is_approve_meeting == 3)
                                                Absent
                                            @else
                                                Not join
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->substitute_name)
                                                {{ $item->substitute_name }}
                                            @else
                                                Self
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($item->meeting_id))
                                                <a href="{{ route('Membermeeting.Membercomment', $item->meeting_id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    View Comments
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No member meetings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3 activity-section d-none" id="member-points-section">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Member Point History</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Points</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($memberPoints as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->points ?? 0 }}</td>
                                        <td>{{ $item->description ?? '-' }}</td>
                                        <td>{{ !empty($item->created_at) ? date('d-m-Y H:i', strtotime($item->created_at)) : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No member points found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3 activity-section d-none" id="visitors-section">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Visitors Created By This Member</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Business Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($visitors as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name ?? '-' }}</td>
                                        <td>{{ $item->phone ?? '-' }}</td>
                                        <td>{{ $item->email ?? '-' }}</td>
                                        <td>{{ $item->business_name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No visitors found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3 activity-section d-none" id="attended-events-section">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Event Attend Meeting Details</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Event Name</th>
                                    <th>Event Start Date</th>
                                    <th>Type</th>
                                    <th>Attend Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendedEvents as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name ?? '-' }}</td>
                                        <td>{{ !empty($item->eventstart_date) ? date('d-m-Y', strtotime($item->eventstart_date)) : '-' }}
                                        </td>
                                        <td>
                                            {{ $item->isapproved_status == 1 ? 'Join' : 'Not Join' }}
                                        </td>

                                        <td>{{ !empty($item->attended_at) ? date('d-m-Y H:i', strtotime($item->attended_at)) : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No event attend records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card activity-section d-none" id="one-to-one-section">
                    <div class="card-header">
                        <h5 class="card-title mb-0">One To One Record Listing</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>To</th>
                                    <th>Place</th>
                                    <th>Date</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($oneToOnes as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->to ?? '-' }}</td>
                                        <td>{{ $item->place ?? '-' }}</td>
                                        <td>{{ !empty($item->date) ? date('d-m-Y', strtotime($item->date)) : '-' }}</td>
                                        <td>{{ $item->comment ?? '-' }}</td>
                                        <td>{{ !empty($item->isapproved_status == 1) ? 'Approve' : 'Pending' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No one to one records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.activity-card');
            const sections = document.querySelectorAll('.activity-section');

            cards.forEach(function(card) {
                card.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');

                    cards.forEach(function(item) {
                        item.classList.remove('active');
                    });
                    this.classList.add('active');

                    sections.forEach(function(section) {
                        section.classList.add('d-none');
                    });

                    const targetSection = document.getElementById(target);
                    if (targetSection) {
                        targetSection.classList.remove('d-none');
                    }
                });
            });
        });
    </script>
@endsection
