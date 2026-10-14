@extends('layouts.app')

@section('title', 'Inducted Report')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')
                <div class="row">
                    <div class="col-12">

                    </div>
                </div>


                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Inducted Report</h5>
                            </div>
                            <div class="card-body">

                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No</th>
                                            <th scope="col">Member Name</th>
                                            <th scope="col">Total Inducted Members</th>
                                            <th scope="col">No of Members Inducted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        ?>
                                        @foreach ($members as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $i + $members->perPage() * ($members->currentPage() - 1) }}</td>
                                                <td class="text-center">
                                                    {{ isset($data->Contact_person) ? $data->Contact_person : '-' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ isset($data->referrals_count) ? $data->referrals_count : '-' }}</td>
                                                <td class="text-center">
                                                    {{ $data->referrals->pluck('Contact_person')->implode(', ') ?: 'N/A' }}
                                                </td>

                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $members->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
            @section('scripts')
            @endsection
