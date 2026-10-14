@extends('layouts.app')
@section('title', 'Members Calendar')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.css" rel="stylesheet">
    <style>
        #memberCalendar {   
            background: #fff;
            padding: 10px;
            border-radius: 8px;
        }

        .fc-event {
            cursor: pointer;
            padding: 3px 5px;
        }

        .fc-daygrid-event {
            white-space: normal;
        }
          /* Birthday - full orange row in list view */
        .fc .fc-list-event.birthday-event>td {
            background-color: #f39c12 !important;
            color: #fff !important;
            border-color: #f39c12 !important;
        }

        /* Birthday title */
        .fc .fc-list-event.birthday-event .fc-list-event-title,
        .fc .fc-list-event.birthday-event .fc-list-event-title a,
        .fc .fc-list-event.birthday-event .fc-list-event-time {
            color: #fff !important;
        }

        /* Dot */
        .fc .fc-list-event.birthday-event .fc-list-event-dot {
            border-color: #fff !important;
        }

        /* Hover */
        .fc .fc-list-event.birthday-event:hover>td {
            background-color: #e8920b !important;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h3 class="mb-1">Member Calendar</h3>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div id="memberCalendar"></div>
                        </div>
                        {{-- @if ($members->isEmpty())
                            <div class="alert alert-info mb-0">No member dates found.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Member Name</th>
                                            <th>Date of Birth</th>
                                            <th>Work Anniversary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $member)
                                            <tr>
                                                <td>{{ $member->member_name ?? '-' }}</td>
                                                <td>
                                                    {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->format('d-m-Y') : '-' }}
                                                </td>
                                                <td>
                                                    {{ $member->work_anniversary_date
                                                        ? \Carbon\Carbon::parse($member->work_anniversary_date)->format('d-m-Y')
                                                        : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $members->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        @endif --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const calendarEl = document.getElementById('memberCalendar');

            const members = @json($calendarMembers);

            const currentYear = new Date().getFullYear();

            let events = [];

            members.forEach(function(member) {

                // Date of Birth
                if (member.date_of_birth) {

                    const dob = new Date(member.date_of_birth);

                    if (!isNaN(dob.getTime())) {

                        const month = String(dob.getMonth() + 1).padStart(2, '0');
                        const day = String(dob.getDate()).padStart(2, '0');

                        events.push({
                            title: '🎂 ' + (member.member_name || 'Member') + ' - Birthday',
                            start: currentYear + '-' + month + '-' + day,
                            allDay: true,
                            type: 'birthday',
                            classNames: ['birthday-event']
                        });
                    }
                }

                // Work Anniversary
               /* if (member.work_anniversary_date) {

                    const anniversary = new Date(member.work_anniversary_date);

                    if (!isNaN(anniversary.getTime())) {

                        const month = String(anniversary.getMonth() + 1).padStart(2, '0');
                        const day = String(anniversary.getDate()).padStart(2, '0');

                        events.push({
                            title: '🏆 ' + (member.member_name || 'Member') + ' - Work Anniversary',
                            start: currentYear + '-' + month + '-' + day,
                            allDay: true,
                            type: 'anniversary'
                        });
                    }
                }
                */
            });

            const calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',

                height: 'auto',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },

                events: events,

                eventDidMount: function(info) {

                    // Hover par title
                    info.el.setAttribute('title', info.event.title);

                    if (info.event.extendedProps.type === 'birthday') {
                        info.el.style.backgroundColor = '#f39c12';
                        info.el.style.borderColor = '#f39c12';
                    }

                    if (info.event.extendedProps.type === 'anniversary') {
                        info.el.style.backgroundColor = '#28a745';
                        info.el.style.borderColor = '#28a745';
                    }
                },

                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                }
            });

            calendar.render();
        });
    </script>
@endsection
