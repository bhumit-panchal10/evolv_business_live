@extends('layouts.app')
@section('title', 'Upcoming Events List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                {{-- Alert Messages --}}

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-success mb-3">

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('Event.PastEventList') ? 'active' : '' }}"
                                        href="{{ route('Event.PastEventList') }}">
                                        <i class="fas fa-clock"></i> Past Event
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('Event.UpcomingEventList') ? 'active' : '' }}"
                                        href="{{ route('Event.UpcomingEventList') }}">
                                        <i class="fas fa-check-circle"></i> Upcoming Event
                                    </a>
                                </li>

                            </ul>
                        </div><!-- end card-body -->
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row flex-between-end">
                                <div class="col-auto align-self-center">
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Upcoming Events List
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
                                                                <img src="{{ asset('event') . '/' . $Event->photo }}"
                                                                    style="width: 50px;height: 50px;">
                                                            </td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($Event->eventstart_date)->format('d-m-Y') }}
                                                            </td>

                                                            <td class="text-center">{{ $Event->eventstart_time }}</td>

                                                            <td class="text-center">{{ $Event->eventend_time }}</td>

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
        </div>
    </div>
    </div>
    {{-- @endforeach --}}
@endsection

@section('scripts')
@endsection
