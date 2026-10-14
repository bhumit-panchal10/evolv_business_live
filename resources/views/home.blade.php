@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <?php $session = Auth::user(); ?>
    <style>
        .cust-over {
            height: 553px;
            overflow: auto;
        }
    </style>
    <div class="main-content">


        {{--  <div style="background-image: url(assets/images/banner1.jpg);height: 550px;">  --}}
        {{--  <img src="{{ asset('assets/images/banner1.jpg') }}" alt="">  --}}
        {{--  </div>  --}}

        <div class="page-content">
            <!-- new code start -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title mb-0" data-anchor="data-anchor">Top 3 Giver Of The Month -
                                            {{ $monthname }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!--Business Reciver And Giver -->
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Direct Business</h4>
                                            </div><!-- end card header -->
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table
                                                        class="table table-borderless table-hover table-nowrap align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr class="text-muted">
                                                                <th scope="col">Sr.No</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Company Name</th>
                                                                <th scope="col">Amount</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($topDirect as $index => $receiver)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $receiver->business_from }}</td>
                                                                    <td>{{ $receiver->companyname }}</td>
                                                                    <td>{{ $receiver->total_amount }}</td>

                                                                </tr>
                                                            @endforeach
                                                        </tbody><!-- end tbody -->
                                                    </table><!-- end table -->
                                                </div><!-- end table responsive -->
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>




                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Reference Business</h4>
                                            </div><!-- end card header -->
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table
                                                        class="table table-borderless table-hover table-nowrap align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr class="text-muted">
                                                                <th scope="col">Sr.No</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Company Name</th>
                                                                <th scope="col">Amount</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($topReference as $index => $Giver)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $Giver->business_from }}</td>
                                                                    <td>{{ $Giver->companyname }}</td>
                                                                    <td>{{ $Giver->total_amount }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody><!-- end tbody -->
                                                    </table><!-- end table -->
                                                </div><!-- end table responsive -->
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
                                    {{-- connection given start --}}
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Reference Given</h4>
                                            </div><!-- end card header -->
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    @if ($TopReferenceGivers > 0)
                                                        <table
                                                            class="table table-borderless table-hover table-nowrap align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr class="text-muted">
                                                                    <th scope="col">Sr.No</th>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">Company Name</th>
                                                                    <th scope="col">Total references</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($Top_Reference_Givers as $index => $Giver)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $Giver->Contact_person }}</td>
                                                                        <td>{{ $Giver->companyname }}</td>
                                                                        <td>{{ $Giver->total_references }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody><!-- end tbody -->
                                                        </table><!-- end table -->
                                                    @else
                                                        <div class="row">
                                                            <div
                                                                class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                                                <div
                                                                    class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                                                    <h1 class="font-white text-center"> No Data Found !
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div><!-- end table responsive -->
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
                                    {{-- connection given end --}}

                                </div>

                                <!--Business Reciver And Giver -->

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-3">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"> Meeting</h4>
                                <div class="flex-shrink-0">
                                    <!--<div class="dropdown card-header-dropdown">-->
                                    <!--    <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                                    <!--        <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>-->
                                    <!--    </a>-->
                                    <!--    <div class="dropdown-menu dropdown-menu-end">-->
                                    <!--        <a class="dropdown-item" href="#">Edit</a>-->
                                    <!--        <a class="dropdown-item" href="#">Remove</a>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                            </div>

                            <div class="card-body cust-over pt-0">
                                <ul class="list-group list-group-flush border-dashed">
                                    @foreach ($meetings as $meeting)
                                        <li class="list-group-item ps-0">
                                            <div class="row align-items-center g-3">
                                                <div class="col-auto">
                                                    <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                                        <div class="text-center">
                                                            <h5 class="mb-0">
                                                                {{ Carbon\Carbon::createFromFormat('d.m.y H:i', $meeting->start_date)->format('d') }}
                                                            </h5>
                                                            <div class="text-muted">
                                                                {{ Carbon\Carbon::createFromFormat('d.m.y H:i', $meeting->start_date)->format('D') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <h5 class="text-muted mt-0 mb-1 fs-14">
                                                        {{ Carbon\Carbon::createFromFormat('d.m.y H:i', $meeting->start_date)->format('d.m.y H:i') }}
                                                        To
                                                        {{ Carbon\Carbon::createFromFormat('d.m.y H:i', $meeting->End_date)->format('d.m.y H:i') }}
                                                    </h5>
                                                    <div class="d-flex justify-content-between">
                                                        <a href="#"
                                                            class="text-reset fs-15 mb-0">{{ $meeting->Meeting_title }}</a>
                                                        <!-- <span class="badge bg-primary rounded-pill">{{ $meeting->member_count }} Members</span> -->
                                                        <a href="{{ route('Membermeeting.Memberindex', $meeting->id) }}"
                                                            class="btn btn-success btn-sm rounded-pill">{{ $meeting->member_count }}
                                                            Members</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div
                                    class="align-items-center justify-content-center mt-2 row g-3 text-center text-sm-start">
                                    <div class="col-sm-auto">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- new code end  -->
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex mb-3">
                                <h4 class="card-title mb-0 flex-grow-1">Business Analysis</h4>
                                <div class="flex-shrink-0">

                                </div>
                            </div>



                            <div class="h-100 p-3">


                                <!--end row-->

                                <div class="row">



                                    {{-- start pending business --}}
                                    <div class="col-xl-3 col-md-3">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #00abc8;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                                                            Business Pending</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-8">
                                                            <span class="counter-value"
                                                                data-target="{{ $pending }}">{{ $pending }}</span>/<span
                                                                class="counter-value"
                                                                data-target="{{ $totalpendingamount }}">{{ $totalpendingamount }}</span>
                                                        </h4>
                                                        @if ($session->role_id == 1)
                                                            <a href="{{ route('Business.index') }}"
                                                                class="text-decoration-underline text-white-50">View Detail

                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fas fa-hourglass-half"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    {{-- end pending business --}}

                                    {{-- start Approve business --}}
                                    <div class="col-xl-3 col-md-3">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #00abc8;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                                                            Business Approve</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">
                                                            <span class="counter-value"
                                                                data-target="{{ $approvecount }}">0</span>/<span
                                                                class="counter-value"
                                                                data-target="{{ $totalapproveamount }}">0</span>
                                                        </h4>
                                                        @if ($session->role_id == 1)
                                                            <a href="{{ route('Business.approve_list') }}"
                                                                class="text-decoration-underline text-white-50">View Detail

                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fas fa-check-circle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    {{-- end Approve business --}}

                                    {{-- start rejected business --}}
                                    <div class="col-xl-3 col-md-3">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #00abc8;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                                                            Business Rejected</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">
                                                            <span class="counter-value"
                                                                data-target="{{ $rejectedcount }}">0</span>/
                                                            <span class="counter-value"
                                                                data-target="{{ $totalrejectedamount }}">0</span>
                                                        </h4>
                                                        @if ($session->role_id == 1)
                                                            <a href="{{ route('Business.rejected_list') }}"
                                                                class="text-decoration-underline text-white-50">View Detail

                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fas fa-times-circle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    {{-- end rejected business --}}


                                    <div class="col-xl-3 col-md-3">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #00abc8;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                                                            Total Active Member</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $active }}">0</span>
                                                        </h4>
                                                        @if ($session->role_id == 1)
                                                            <a href="{{ route('members.index') }}"
                                                                class="text-decoration-underline text-white-50">View Detail
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fas fa-users"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    <!-- Chart Section  start-->


                                    <!-- Chart Section end -->
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ env('APP_NAME') }}.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->


@endsection
<!-- col chart -->
@section('scripts')

    <!-- New code start -->
    <style>
        a.canvasjs-chart-credit {
            display: none;
        }
    </style>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "",
                    fontSize: 16
                },
                axisY: {
                    title: "Total",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    lineThickness: 2
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: [{
                        type: "column",
                        name: "Total Direct Business",
                        legendText: "Total Direct Business",
                        showInLegend: true,
                        color: "#6fbd59",
                        dataPoints: [
                            @foreach ($formatted_combined_data as $data)
                                {
                                    label: "{{ substr($data['month'], 0, 3) ?? 'Unknown' }}-{{ substr($data['year'], -2) ?? 'Unknown' }}",
                                    y: {{ $data['total_given'] ?? 0 }}
                                },
                            @endforeach
                        ]
                    },
                    {
                        type: "column",
                        name: "Total Reference Business",
                        legendText: "Total Reference Business",
                        showInLegend: true,
                        color: "#59bda4",
                        dataPoints: [
                            @foreach ($formatted_combined_data as $data)
                                {
                                    label: "{{ substr($data['month'], 0, 3) ?? 'Unknown' }}-{{ substr($data['year'], -2) ?? 'Unknown' }}",
                                    y: {{ $data['total_received'] ?? 0 }}
                                },
                            @endforeach
                        ]
                    }
                ]
            });
            chart.render();

            function toggleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }
    </script>


@endsection
<!-- col chart -->
