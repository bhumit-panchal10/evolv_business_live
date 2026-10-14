@extends('layouts.app')
@section('title', 'Cluster Feedback List')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                {{-- Alert Messages --}}
                @include('common.alert')

                <!--search start-->
                <!-- <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="form" action="{{ route('ClusterfestFeedback.index') }}">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-3 mb-2">
                                        <input placeholder="Enter From Date" type="text" class="form-control"
                                            id="startdatepicker" name="fromdate" autocomplete="off"
                                            value="{{ isset($FromDate) ? $FromDate : '' }}">
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <input placeholder="Enter To Date" type="text" class="form-control"
                                            id="enddatepicker" name="todate" autocomplete="off"
                                            value="{{ isset($ToDate) ? $ToDate : '' }}">
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <div class="input-group d-flex" style="justify-content: space-around;">
                                            <input type="submit" id="search" class="btn btn-success" value="Search">
                                            <button type="button" id="cancel_search" class="btn btn-success">Cancel</button>
                                            <button class="btn btn-success" type="button" onclick="exportExcel();">
                                                <i class="fa-solid fa-file-excel fa-xl"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> -->
                <!--search end-->

                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Cluster Feedback List</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    @if ($feedbacks->count() > 0)
                                        <div class="table-responsive scrollbar">
                                            <table class="table table-bordered table-striped fs--1 mb-0">
                                                <thead class="bg-200 text-900">
                                                    <tr>
                                                        <th scope="col">Sr No</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Brand Name</th>
                                                        <th scope="col">Business Category</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">First Experience</th>
                                                        <th scope="col">Experience Feedback</th>
                                                        <th scope="col">Join Next Meet</th>
                                                        <th scope="col">Preferred Date</th>
                                                        <th scope="col">Submitted On</th>   
                                                         <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp
                                                    @foreach ($feedbacks as $feedback)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $feedbacks->perPage() * ($feedbacks->currentPage() - 1) }}
                                                            </td>
                                                            <td class="text-center">{{ $feedback->name ?? '-' }}</td>
                                                            <td class="text-center">{{ $feedback->brand_name ?? '-' }}</td>
                                                            <td class="text-center">{{ $feedback->business_category ?? '-' }}</td>
                                                            <td class="text-center">{{ $feedback->email ?? '-' }}</td>
                                                            <td class="text-center">
                                                                {{ $feedback->first_experience == 'Yes' ? 'Yes' : 'No' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $feedback->experience_feedback ?? '-' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $feedback->join_next_meet == 'Yes' ? 'Yes' : 'No' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $feedback->preferred_date ?? '-' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $feedback->created_at ? \Carbon\Carbon::parse($feedback->created_at)->format('d-m-y') : 'N/A' }}
                                                            </td>
                                                            <td class="text-center">
                                                                <form action="{{ route('ClusterfestFeedback.delete', $feedback->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $feedbacks->links() }}
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    <h4>No Feedback Found!</h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    
@endsection
