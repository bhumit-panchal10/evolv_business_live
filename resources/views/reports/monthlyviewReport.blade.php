@extends('layouts.app')

@section('title', 'Monthly View Report')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">

                            <form method="GET" action="{{ route('reports.monthlyreview') }}">
                                <div class="row mb-3">

                                    <div class="col-md-3">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" class="form-control"
                                            value="{{ request('from_date') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" class="form-control"
                                            value="{{ request('to_date') }}">
                                    </div>

                                    <div class="col-md-3 mt-4">
                                        <button class="btn btn-primary"
                                            style="background: #61a143 !important;border:1px solid #61a143 !important; ">
                                            Search
                                        </button>

                                        <a href="{{ route('reports.monthlyreview') }}" class="btn btn-secondary"
                                            style="background: #61a143 !important;border:1px solid #61a143 !important; ">
                                            Reset
                                        </a>
                                         <a href="{{ route('reports.monthlyreview.export', request()->query()) }}"
                                            class="btn btn-success">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Monthly View Report</h5>
                                </div>
                                <div class="card-body">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>City Group</th>
                                                <th>Member Of The Month</th>
                                                <th>Total Points</th>
                                                <th>Highest Direct Business</th>
                                                <th>Direct Amount</th>
                                                <th>Group Total Direct Amount</th>
                                                <th>Highest Referral Business</th>
                                                <th>Referral Amount</th>
                                                <th>Group Total Referral Amount</th>
                                                <th>Total Business</th>
                                                <th>Group Total Referral Count</th>
                                                <th>Top One To One</th>
                                                <th>Total One To One</th>
                                                <th>Group Total One To One Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reportData as $row)
                                                <tr>
                                                    <td>{{ $row['city_group'] }}</td>

                                                    <td>
                                                        {{ $row['member_of_the_month']->Contact_person ?? '-' }}
                                                        <br>
                                                        <small>{{ $row['member_of_the_month']->companyname ?? '' }}</small>
                                                    </td>

                                                    <td>
                                                        {{ $row['member_of_the_month']->total_points ?? 0 }}
                                                    </td>

                                                    <td>
                                                        {{ $row['top_direct_business']->Contact_person ?? '-' }}
                                                    </td>

                                                    <td>
                                                        ₹{{ number_format($row['top_direct_business']->total_amount ?? 0, 2) }}
                                                    </td>

                                                    <td>
                                                        ₹{{ number_format($row['totalDirectBusiness'] ?? 0, 2) }}
                                                    </td>

                                                    <td>
                                                        {{ $row['top_reference_business']->Contact_person ?? '-' }}
                                                    </td>

                                                    <td>
                                                        ₹{{ number_format($row['top_reference_business']->total_amount ?? 0, 2) }}
                                                    </td>

                                                    <td>
                                                        ₹{{ number_format($row['totalReferenceBusiness'] ?? 0, 2) }}
                                                    </td>
                                                    <td>
                                                        ₹{{ number_format(($row['totalReferenceBusiness'] ?? 0) + ($row['totalDirectBusiness'] ?? 0), 2) }}
                                                    </td>
                                                    <td>
                                                        {{ $row['totalReferralCount'] ?? 0 }}
                                                    </td>

                                                    <td>
                                                        {{ $row['top_one_to_one']->Contact_person ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ $row['top_one_to_one']->total_meetings ?? 0 }}
                                                    </td>
                                                    <td>
                                                        {{ $row['totalOneToOne'] ?? 0 }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- <div class="d-flex justify-content-center mt-3">
                                    {{ $reportData->links() }}
                                </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endsection
                @section('scripts')
                @endsection
