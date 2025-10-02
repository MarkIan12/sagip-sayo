@extends('layouts.header')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-xxl-5">
        <div class="d-flex flex-column h-100">
          
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Incidents</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="28.05">0</span>k</h2>
                                    <p class="mb-0 text-muted text-truncate"><span class="badge bg-light text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 16.24 % </span> vs. previous year</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="users" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">This month</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="97.66">0</span>k</h2>
                                    <p class="mb-0 text-muted text-truncate"><span class="badge bg-light text-danger mb-0"> <i class="ri-arrow-down-line align-middle"></i> 3.96 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="activity" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row-->

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Avg. Incident per Month</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="30">0</span>
                                        {{-- <span class="counter-value" data-target="40">0</span>sec --}}
                                    </h2>
                                    <p class="mb-0 text-muted text-truncate"><span class="badge bg-light text-danger mb-0"> <i class="ri-arrow-down-line align-middle"></i> 0.24 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="clock" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Bounce Rate</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="33.48">0</span>%</h2>
                                    <p class="mb-0 text-muted text-truncate"><span class="badge bg-light text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 7.05 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="external-link" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div>
    </div> <!-- end col-->

    <div class="col-xxl-7">
        <div class="row h-100">
            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Mandaluyong City</h4>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-soft-primary btn-sm material-shadow-none">
                                Export Report
                            </button>
                        </div>
                    </div><!-- end card header -->

                    <!-- card body -->
                    <div class="card-body">

                        <div id="users-by-country" data-colors='["--vz-light"]' class="text-center" style="height: 252px"></div>

                        <div class="table-responsive table-card mt-3">
                            <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-1">
                                <thead class="text-muted border-dashed border border-start-0 border-end-0 bg-light-subtle">
                                    <tr>
                                        <th>Duration (Secs)</th>
                                        <th style="width: 30%;">Sessions</th>
                                        <th style="width: 30%;">Views</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    <tr>
                                        <td>0-30</td>
                                        <td>2,250</td>
                                        <td>4,250</td>
                                    </tr>
                                    <tr>
                                        <td>31-60</td>
                                        <td>1,501</td>
                                        <td>2,050</td>
                                    </tr>
                                    <tr>
                                        <td>61-120</td>
                                        <td>750</td>
                                        <td>1,600</td>
                                    </tr>
                                    <tr>
                                        <td>121-240</td>
                                        <td>540</td>
                                        <td>1,040</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Baranggays</h4>
                        <div>
                            <button type="button" class="btn btn-soft-secondary btn-sm material-shadow-none">
                                ALL
                            </button>
                            <button type="button" class="btn btn-soft-primary btn-sm material-shadow-none">
                                1M
                            </button>
                            <button type="button" class="btn btn-soft-secondary btn-sm material-shadow-none">
                                6M
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div>
                            <div id="countries_charts" data-colors='["--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-danger", "--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-info"]' data-colors-minimal='["--vz-primary", "--vz-primary", "--vz-primary", "--vz-primary", "--vz-primary-rgb, 0.45", "--vz-primary", "--vz-primary", "--vz-primary", "--vz-primary", "--vz-primary"]' data-colors-material='["--vz-primary", "--vz-primary", "--vz-info", "--vz-info", "--vz-danger", "--vz-primary", "--vz-primary", "--vz-warning", "--vz-primary", "--vz-primary"]' data-colors-galaxy='["--vz-primary-rgb, 0.4", "--vz-primary-rgb, 0.4", "--vz-primary-rgb, 0.4", "--vz-primary-rgb, 0.4", "--vz-primary", "--vz-primary-rgb, 0.4", "--vz-primary-rgb, 0.4", "--vz-primary-rgb, 0.4", "--vz-primary-rgb, 0.4", "--vz-primary-rgb, 0.4"]' data-colors-classic='["--vz-primary", "--vz-primary", "--vz-primary", "--vz-primary", "--vz-primary-rgb, 0.45", "--vz-primary", "--vz-primary", "--vz-primary", "--vz-primary", "--vz-primary"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div> <!-- end col-->

        </div> <!-- end row-->
    </div><!-- end col -->
</div> <!-- end row-->

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Incident Monthly</h4>
                <div>
                    <button type="button" class="btn btn-soft-secondary btn-sm material-shadow-none">
                        ALL
                    </button>
                    <button type="button" class="btn btn-soft-secondary btn-sm material-shadow-none">
                        1M
                    </button>
                    <button type="button" class="btn btn-soft-secondary btn-sm material-shadow-none">
                        6M
                    </button>
                    <button type="button" class="btn btn-soft-primary btn-sm material-shadow-none">
                        1Y
                    </button>
                </div>
            </div><!-- end card header -->
            <div class="card-header p-0 border-0 bg-light-subtle">
                <div class="row g-0 text-center">
                    <div class="col-6 col-sm-4">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1"><span class="counter-value" data-target="854">0</span>
                                <span class="text-success ms-1 fs-12">49%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                            </h5>
                            <p class="text-muted mb-0">Avg. Session</p>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-6 col-sm-4">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1"><span class="counter-value" data-target="1278">0</span>
                                <span class="text-success ms-1 fs-12">60%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                            </h5>
                            <p class="text-muted mb-0">Conversion Rate</p>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-6 col-sm-4">
                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                            <h5 class="mb-1"><span class="counter-value" data-target="3">0</span>m
                                <span class="counter-value" data-target="40">0</span>sec
                                <span class="text-success ms-1 fs-12">37%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                            </h5>
                            <p class="text-muted mb-0">Avg. Session Duration</p>
                        </div>
                    </div>
                    <!--end col-->
                </div>
            </div><!-- end card header -->
            <div class="card-body p-0 pb-2">
                <div>
                    <div id="audiences_metrics_charts" data-colors='["--vz-success", "--vz-light"]' data-colors-minimal='["--vz-primary", "--vz-light"]' data-colors-modern='["--vz-primary", "--vz-light"]' data-colors-interactive='["--vz-primary", "--vz-light"]' data-colors-creative='["--vz-secondary", "--vz-light"]' data-colors-corporate='["--vz-primary", "--vz-light"]' data-colors-galaxy='["--vz-primary", "--vz-light"]' data-colors-classic='["--vz-primary", "--vz-secondary"]' data-colors-vintage='["--vz-primary", "--vz-success-rgb, 0.5"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-6">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Audiences Sessions by Country</h4>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fw-semibold text-uppercase fs-12">Sort by: </span><span class="text-muted">Current Week<i class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Today</a>
                            <a class="dropdown-item" href="#">Last Week</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Current Year</a>
                        </div>
                    </div>
                </div>
            </div><!-- end card header -->
            <div class="card-body p-0">
                <div>
                    <div id="audiences-sessions-country-charts" data-colors='["--vz-success", "--vz-info"]' data-colors-minimal='["--vz-info", "--vz-primary"]' data-colors-modern='["--vz-success", "--vz-secondary"]' data-colors-interactive='["--vz-info", "--vz-primary"]' data-colors-creative='["--vz-primary", "--vz-success"]' data-colors-corporate='["--vz-secondary", "--vz-primary"]' data-colors-galaxy='["--vz-primary", "--vz-secondary"]' data-colors-classic='["--vz-primary", "--vz-danger"]' data-colors-vintage='["--vz-success", "--vz-secondary"]' class="apex-charts" dir="ltr"> </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

<div class="row">
    <div class="col-xl-4">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Incident Type</h4>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted fs-16"><i class="mdi mdi-dots-vertical align-middle"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Today</a>
                            <a class="dropdown-item" href="#">Last Week</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Current Year</a>
                        </div>
                    </div>
                </div>
            </div><!-- end card header -->
            <div class="card-body">
                <div id="user_device_pie_charts" data-colors='["--vz-primary", "--vz-warning", "--vz-info"]' data-colors-minimal='["--vz-primary", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.75"]' data-colors-galaxy='["--vz-primary", "--vz-primary-rgb, .75", "--vz-primary-rgb, 0.60"]' class="apex-charts" dir="ltr"></div>

                <div class="table-responsive mt-3">
                    <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                        <tbody class="border-0">
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Desktop Users</h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>78.56k</p>
                                </td>
                                <td class="text-end">
                                    <p class="text-success fw-medium fs-12 mb-0"><i class="ri-arrow-up-s-fill fs-5 align-middle"></i>2.08% </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>Mobile Users</h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>105.02k</p>
                                </td>
                                <td class="text-end">
                                    <p class="text-danger fw-medium fs-12 mb-0"><i class="ri-arrow-down-s-fill fs-5 align-middle"></i>10.52%
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-info me-2"></i>Tablet Users</h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>42.89k</p>
                                </td>
                                <td class="text-end">
                                    <p class="text-danger fw-medium fs-12 mb-0"><i class="ri-arrow-down-s-fill fs-5 align-middle"></i>7.36%
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->


    <div class="col-xl-4 col-md-6">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Latest Encode</h4>
               
            </div><!-- end card header -->
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table align-middle table-borderless table-centered table-nowrap mb-0">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col" style="width: 62;">Incident</th>
                                <th scope="col">Details</th>
                                <th scope="col">Encoded by</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="javascript:void(0);">/themesbrand/skote-25867</a>
                                </td>
                                <td>99</td>
                                <td>25.3%</td>
                            </tr><!-- end -->
                              
                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div><!-- end -->
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->
@endsection
@section('js')
  <!-- apexcharts -->
  <script src="{{asset('inside_css/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

  <!-- Vector map-->
  <script src="{{asset('inside_css/assets/libs/jsvectormap/jsvectormap.min.js')}}"></script>
  <script src="{{asset('inside_css/assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

  <!-- Dashboard init -->
  <script src="{{asset('inside_css/assets/js/pages/dashboard-analytics.init.js')}}"></script>
@endsection
