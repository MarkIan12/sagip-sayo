<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- @laravelPWA --}}
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sagip') }}</title>
    <link rel="shortcut icon" href="{{url('images/Favicon.png')}}">

    <!-- Layout config Js -->
    <script src="{{asset('inside_css/assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('inside_css/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('inside_css/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('inside_css/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('inside_css/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}
    @yield('css')
    <style>
        .helpdesk-link-wrapper {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('images/loader.gif') }}") 50% 50% no-repeat white;
            opacity: .8;
            background-size: 120px 120px;
        }   
        </style>

</head>
<body>
    <div id = "loader" class="loader">
    </div>
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{url('/')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('images/Favicon.png')}}" alt="" height="100">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('images/Favicon.png')}}" alt="" height="100">
                                </span>
                            </a>

                            <a href="{{url('/')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('images/Favicon.png')}}" alt="" height="100">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('images/Favicon.png')}}" alt="" height="100">
                                </span>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{asset(auth()->user()->avatar)}}" onerror="this.src='{{url('images/manda.png')}}';" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{current(explode(' ',auth()->user()->name))}}</span>
                                        {{-- <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Founder</span> --}}
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome {{current(explode(' ',auth()->user()->name))}}!</h6>
                                {{-- <a class="dropdown-item" href="{{url('/my-profile')}}" ><i class="mdi mdi-account-outline  text-muted fs-6 align-middle me-1"></i> <span class="align-middle">My Profile</span></a> --}}
                                {{-- <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserPassword"><i class="mdi mdi-key text-muted fs-6 align-middle me-1"></i> <span class="align-middle">Change Password</span></a> --}}
                                {{-- <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changeAvatar"><i class="mdi mdi-file-image text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Change Avatar</span></a> --}}
                              <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a> --}}
                              <div class="dropdown-divider"></div>
                               <a class="dropdown-item" href="{{ route('logout') }}" onclick="logout(); show();"> <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

<!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <!-- <a href="{{url('/')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('images/Favicon.png')}}" alt="" height="100">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('images/Favicon.png')}}" alt="" height="100">
                    </span>
                </a> -->
                <!-- Light Logo-->
                <a href="{{url('/')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('images/logo-manda.png')}}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('images/logo-manda.png')}}" alt="" height="50">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
    
        
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu"></div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('/')}}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('/incidents')}}">
                                <i class="ri-list-check"></i> <span data-key="t-dashboards">Incidents</span>
                            </a>
                        </li>
                       <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/traffic-map') }}">
                                <i class="ri-map-pin-2-line"></i> <span data-key="t-maps">Traffic Map</span>
                            </a>
                        </li>
                        
                        @if(auth()->user()->role == "Admin")
                            <li class="menu-title"><span data-key="t-menu">Admin</span></li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{url('/streets')}}">
                                    <i class="mdi mdi-road-variant"></i> <span data-key="t-dashboards">Streets</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{url('/barangays')}}">
                                    <i class="mdi mdi-town-hall"></i> <span data-key="t-dashboards">Barangays</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{url('/incident_types')}}">
                                    <i class="mdi mdi-cog"></i> <span data-key="t-dashboards">Incident Types</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{url('/users')}}">
                                    <i class="ri-team-fill"></i> <span data-key="t-dashboards">Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{url('/reports')}}">
                                    <i class="ri-file-list-3-fill"></i> <span data-key="t-dashboards">Reports</span>
                                </a>
                            </li>
                        @endif
                        {{-- <li class="nav-item">
                            <a class="nav-link menu-link" href="https://api.saltiii.com/api/documentation" target="_blank">
                                <i class="ri-shield-keyhole-line"></i> <span data-key="t-dashboards">API</span>
                            </a>
                        </li> --}}
                        {{-- @endif --}}
                
                    </ul>
                    {{-- <div class="helpdesk-link-wrapper mt-auto">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link menu-link bg-white" href="https://saltiii.freshdesk.com/support/home" target="_blank">
                                    <i class="ri-customer-service-2-line"></i> 
                                    <span data-key="t-submit-ticket" class="text-warning">Need Support?</span>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
                
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                        <div class="row">
                            <!-- <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                    <h4 class="mb-sm-0">{{Route::current()->getName()}}</h4>
                                </div>
                            </div> -->
                        </div>
                        @yield('content')
                    </div>
                </div>
            
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                {{date('Y')}} © SAGIP
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by <span>.<</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
    </div>


    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

  

    <!-- Theme Settings -->
 @include('layouts.change_password')
 @include('change_avatar')
        @include('sweetalert::alert')
    <!-- JAVASCRIPT -->
    <script src="{{asset('inside_css/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('inside_css/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('inside_css/assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('inside_css/assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('inside_css/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('inside_css/assets/js/plugins.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- apexcharts -->

   @yield('js')
    <!-- App js -->
    <script src="{{asset('inside_css/assets/js/app.js')}}"></script>
 
    <script>
         function show() {
            document.getElementById("loader").style.display = "block";
        }
        function logout() {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    }

</script>
<script>
    window.addEventListener('load', function() {
        document.getElementById('loader').style.display = 'none';
    });
</script>
</body>
</html>
