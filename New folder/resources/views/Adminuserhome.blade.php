@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- {{(dd('comming'))}} --}}
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

    
        {{--  <div style="background-image: url(assets/images/banner1.jpg);height: 550px;">  --}}
        {{--  <img src="{{ asset('assets/images/banner1.jpg') }}" alt="">  --}}
        {{--  </div>  --}}

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col">

                        <div class="h-100">
                            <div class="row mb-3 pb-1">
                                <div class="col-12">
                                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                        <div class="flex-grow-1">
                                            <h4 class="fs-16 mb-1">Dashboard</h4>
                                        </div>

                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                            <div class="row">

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate" style="background: #11b29d;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                                                        Upcoming Renewal </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">
                                                        <span class="counter-value"
                                                            data-target="{{ $upcoming }}">0</span>
                                                    </h4>
                                                    <a href="#"
                                                        class="text-decoration-underline text-white-50">View
                                                        Upcoming Renewal</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-light rounded fs-3">
                                                        <i class="fa-solid fa-box-open"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate" style="background: #70b2ce;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                                                        Payment Collection</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">
                                                        <span class="counter-value"
                                                            data-target="{{ $Financed }}">0</span>
                                                    </h4>
                                                    <a href="#"
                                                        class="text-decoration-underline text-white-50">View
                                                        Payment Collection </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-light rounded fs-3">
                                                        <i class="fa-solid fa-coins"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                {{-- start pending business --}}
                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate" style="background: #6fbd59;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                                                        Business Pending</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">
                                                        <span class="counter-value"
                                                            data-target="{{ $pending }}">0</span>
                                                    </h4>
                                                    <a href="#"
                                                        class="text-decoration-underline text-white-50">View
                                                        Business Pending </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-light rounded fs-3">
                                                        <i class="fa-solid fa-coins"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                                {{-- end pending business --}}

                                  {{-- start Approve business --}}
                                  <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate" style="background: #59bda4;">
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
                                                            data-target="{{ $approvecount }}">0</span>
                                                    </h4>
                                                    <a href="#"
                                                        class="text-decoration-underline text-white-50">View
                                                        Business Approve </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-light rounded fs-3">
                                                        <i class="fa-solid fa-coins"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                                {{-- end Approve business --}}

                                    {{-- start rejected business --}}
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #8abc44;">
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
                                                                data-target="{{ $rejectedcount }}">0</span>
                                                        </h4>
                                                        <a href="#"
                                                            class="text-decoration-underline text-white-50">View
                                                            Business Rejected </a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fa-solid fa-coins"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    {{-- end rejected business --}}
 
                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate" style="background: #23b2b7;">
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
                                                            class="counter-value" data-target="{{ $active }}">0</span>
                                                    </h4>
                                                    <a href="#"
                                                        class="text-decoration-underline text-white-50">View
                                                        Members</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-light rounded fs-3">
                                                        <i class="fa-solid fa-coins"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

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
                        </script> © {{env('APP_NAME')}}.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->


@endsection
