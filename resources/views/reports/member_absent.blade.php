@extends('layouts.app')
@section('title', 'Report Detail List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <h4 class="mb-4">Member Absent Report</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="GET" action="{{ route('member.absent.report') }}" class="mb-4">
                    <input type="hidden" name="search" value="1">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="city_group_id">City Group</label>

                            <select name="city_group_id" id="city_group_id" class="form-control">
                                <option value="">All City Groups</option>

                                @foreach ($cityGroups as $group)
                                    <option value="{{ $group->id }}"
                                        {{ (string) request('city_group_id') === (string) $group->id ? 'selected' : '' }}>
                                        {{ $group->group_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="from_date">From Date</label>

                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="to_date">To Date</label>

                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">
                                Search
                            </button>

                            <a href="{{ route('member.absent.report') }}" class="btn btn-success ml-2">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                @if ($searched)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Member Name</th>
                                    <th>Meeting Absent Count</th>
                                    <th>City Group Name</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($reports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $report->member_name }}</td>
                                        <td>{{ $report->absent_count }}</td>
                                        <td>{{ $report->city_group_name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No absent records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Select filters and click Search to view the report.
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection
