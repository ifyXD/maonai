<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
    id="sidenavAccordion">
    <a class="navbar-brand" href="index.html">General Service Office</a>
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle"><i
            data-feather="menu"></i></button>
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ml-auto">
        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <img class="img-fluid" src="assets/img/1.jpg" />
            </a>
            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"
                aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <div class="dropdown-user-details">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            v-pre>{{ Auth::user()->username }}</a>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="profile">Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
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
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <div class="sidenav-menu-heading">Administrator</div>
                        <a class="nav-link" href="{{url('contacts')}}">
                            <div class="nav-link-icon"><i data-feather="filter"></i></div>
                            Dashboard
                        </a>
                    @else
                        <div class="sidenav-menu-heading">UserDashboard</div>
                        <a class="nav-link" href="{{url('/users/dashboard')}}">
                            <div class="nav-link-icon"><i data-feather="filter"></i></div>
                            Dashboard
                        </a>
                    @endif
                    <!-- Sidenav Accordion (Dashboard)-->

                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                            data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                            <div class="nav-link-icon"><i data-feather="activity"></i></div>
                            Job Request Management
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDashboards" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                <a class="nav-link" href="/contacts/pending">Pending <span
                                        class="badge badge-warning-soft text-warning ml-auto">Updated</span></a>
                                <a class="nav-link" href="/contacts/accepted">Accepted <span
                                        class="badge badge-success-soft text-success ml-auto">Updated</span></a>
                                <a class="nav-link" href="/contacts/declined">Declined <span
                                        class="badge badge-danger-soft text-danger ml-auto">Updated</span></a>
                            </nav>
                        </div>
                    @endif

                    <!-- Sidenav Heading (App Views)-->
                    <!-- Sidenav Accordion (Flows)-->
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                            data-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
                            <div class="nav-link-icon"><i data-feather="repeat"></i></div>
                            Vehicles Management
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseFlows" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="drivers">Drivers</a>
                                <a class="nav-link" href="mechanics">Mechanics</a>
                                <a class="nav-link" href="fuel">Fuels</a>
                                <a class="nav-link" href="vehicle">Vehicles</a>
                                <a class="nav-link" href="maintenance">Maintenances</a>
                            </nav>
                        </div>
                    @endif
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                            data-target="#collapseVehicles" aria-expanded="false" aria-controls="collapseVehicles">
                            <div class="nav-link-icon"><i data-feather="activity"></i></div>
                            Request Vehicles Management
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseVehicles" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                {{-- <a class="nav-link" href="#">Main <span
                                        class="badge badge-primary-soft text-primary ml-auto">Updated</span></a> --}}
                                <a class="nav-link" href="{{url('admin/pending-requests/vehicle-bookings')}}">Pending <span
                                        class="badge badge-warning-soft text-warning ml-auto">Updated</span></a>
                                <a class="nav-link" href="{{url('admin/accepted-requests/vehicle-bookings')}}">Accepted <span
                                        class="badge badge-success-soft text-success ml-auto">Updated</span></a>
                                <a class="nav-link" href="{{url('admin/declined-requests/vehicle-bookings')}}">Declined <span
                                        class="badge badge-danger-soft text-danger ml-auto">Updated</span></a>
                            </nav>
                        </div>
                    @endif
                    @if (auth()->check() && auth()->user()->role === 'user')
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                            data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                            <div class="nav-link-icon"><i data-feather="activity"></i></div>
                            Requested Vehicle
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUsers" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                <a class="nav-link" href="{{route('create-request-vehicle.user')}}">Create Request Here <span>
                                </a>
                                <a class="nav-link" href="{{route('all-requests.user')}}">All Request<span>
                                </a>

                                <!-- Add links for All Users here -->
                            </nav>
                        </div>
                    @endif
                    @if (auth()->check() && auth()->user()->role === 'user')
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                            data-target="#collapseVehicles" aria-expanded="false" aria-controls="collapseVehicles">
                            <div class="nav-link-icon"><i data-feather="activity"></i></div>
                            Technical Request Here
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseVehicles" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                <a class="nav-link" href="#">Create Request Here <span></a>
                                <a class="nav-link" href="#">All Request<span></a>
                                <!-- Add links for All Users here -->
                            </nav>
                        </div>
                    @endif

                    <!-- Users-->



                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <a class="nav-link" href="reports">
                            <div class="nav-link-icon"><i data-feather="filter"></i></div>
                            Reports Managements
                        </a>
                    @endif

                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <div class="sidenav-menu-heading">Users</div>
                    @endif
                    <!-- Sidenav Link (Tables)-->

                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                            data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                            <div class="nav-link-icon"><i data-feather="users"></i></div>
                            User Management
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUsers" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="{{url('admin/create')}}">Create Users</a>
                                <a class="nav-link" href="{{url('admin/users')}}">All Users</a>
                                {{-- <a class="nav-link" href="recovery">Recovery accounts</a> --}}
                                <a class="nav-link" href="{{url('admin/departments')}}">Department</a>
                            </nav>
                        </div>
                    @endif


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
