<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    

    <!-- Scripts -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

</head>
<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand" href="index.html">General Service Office</a>
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle"><i data-feather="menu"></i></button>
        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ml-auto">
            <!-- User Dropdown-->
            <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="img-fluid" src="assets/img/1.jpg" />
                </a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <div class="dropdown-user-details">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->username }}</a>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <!-- Sidenav Link (Messages)-->
                        <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                        <a class="nav-link d-sm-none" href="#!">
                            <div class="nav-link-icon"><i data-feather="mail"></i></div>
                            Messages <span class="badge badge-success-soft text-success ml-auto">2 New!</span>
                        </a>
                        <!-- Sidenav Menu Heading (Admin)-->
                        <div class="sidenav-menu-heading">Administrator</div>
                        <!-- Sidenav Accordion (Dashboard)-->
                        <a class="nav-link" href="dashboard">
                            <div class="nav-link-icon"><i data-feather="filter"></i></div>
                            Dashboard
                        </a>    
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                            <div class="nav-link-icon"><i data-feather="activity"></i></div>
                            Job Request Management
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDashboards" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                <a class="nav-link" href="pending_requests">Pending <span class="badge badge-warning-soft text-warning ml-auto">Updated</span></a>
                                <a class="nav-link" href="accepted_requests">Accepted <span class="badge badge-success-soft text-success ml-auto">Updated</span></a>
                                <a class="nav-link" href="declined_requests">Declined <span class="badge badge-danger-soft text-danger ml-auto">Updated</span></a>
                            </nav>
                        </div>
                        <!-- Sidenav Heading (App Views)-->
                        <!-- Sidenav Accordion (Flows)-->
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
                            <div class="nav-link-icon"><i data-feather="repeat"></i></div>
                            Vehicles Management
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>    
                        <div class="collapse" id="collapseFlows" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="vehicle">Vehicles</a>
                                <a class="nav-link" href="maintenance">Maintenances</a>
                                <a class="nav-link" href="mechanics">Mechanics</a>
                                <a class="nav-link" href="#">Driver</a>
                                <a class="nav-link" href="fuel">Fuel Types</a>



                               

                                
                            </nav>
                        </div>
                        <a class="nav-link" href="destination">
                            <div class="nav-link-icon"><i data-feather="filter"></i></div>
                            Trip Destination
                        </a>
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseVehicles" aria-expanded="false" aria-controls="collapseVehicles">
                            <div class="nav-link-icon"><i data-feather="activity"></i></div>
                            Request Vehicles Management
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseVehicles" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                <a class="nav-link" href="#">Main <span class="badge badge-primary-soft text-primary ml-auto">Updated</span></a>
                                <a class="nav-link" href="#">Pending <span class="badge badge-warning-soft text-warning ml-auto">Updated</span></a>
                                <a class="nav-link" href="#">Accepted <span class="badge badge-success-soft text-success ml-auto">Updated</span></a>
                                <a class="nav-link" href="#">Declined <span class="badge badge-danger-soft text-danger ml-auto">Updated</span></a>
                            </nav>
                        </div>
                        <div class="sidenav-menu-heading">Users</div>
                        <!-- Sidenav Link (Tables)-->
                        <a class="nav-link" href="tables.html">
                            <div class="nav-link-icon"><i data-feather="filter"></i></div>
                            User Management
                        </a>
                        <a class="nav-link" href="departments">
                            <div class="nav-link-icon"><i data-feather="filter"></i></div>
                            Departments
                        </a>
                        
                    </div>
                </div>

                
                <!-- Sidenav Footer-->
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content mb-10">
                        <div class="sidenav-footer-subtitle">Logged in as:</div>
                        <div class="sidenav-footer-title">Valerie Luna</div>
                    </div>
                </div>
            </nav>
        </div>
        {{-- <style>
            .is-deleted {
                text-decoration: line-through;
                color: red;
            }
        </style> --}}
        <div id="layoutSidenav_content">
            @yield('content')
        </div>
    </div>
   <!-- Include jQuery, Bootstrap, Chart.js, DataTables, Moment.js, and your custom scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>


<script>
    
//  $(document).ready(function() {
//     $('#dataTable thead th').each(function(index) {
//         var columnId = 'column-' + index; // Generate a unique identifier for each column
//         $(this).html('<div class="d-flex justify-content-between align-items-center"><span>' + $(this).text() + '</span><div class="sorting-icons" id="' + columnId + '"><i class="fas fa-sort-up sort-up" data-index="' + index + '"></i><i class="fas fa-sort-down sort-down" data-index="' + index + '"></i></div></div>');
//     });

//     $('#dataTable').on('click', '.sort-up', function() {
//         var columnIndex = $(this).data('index');
//         var columnId = '#column-' + columnIndex; // Get the unique identifier for the column
//         table.order([columnIndex, 'asc']).draw();
//         resetSortingIcons(columnId);
//         $(this).addClass('active');
//     });

//     $('#dataTable').on('click', '.sort-down', function() {
//         var columnIndex = $(this).data('index');
//         var columnId = '#column-' + columnIndex; // Get the unique identifier for the column
//         table.order([columnIndex, 'desc']).draw();
//         resetSortingIcons(columnId);
//         $(this).addClass('active');
//     });

//     function resetSortingIcons(columnId) {
//         $('.sorting-icons').not(columnId).find('.sort-up, .sort-down').removeClass('active');
//     }
// });


    feather.replace();
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> --}}
@stack('scripts')
</body>
</html>
