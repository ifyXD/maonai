    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin Pro</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <style>
            body {
                background: linear-gradient(to right, #227A0C, #A1BE41); /* Set linear gradient background */
            }
        </style>
    </head>
    <body class="nav-fixed">
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <!-- Navbar Brand-->
            <!-- * * Tip * * You can use text or an image for your navbar brand.-->
            <!-- * * * * * * When using an image, we recommend the SVG format.-->
            <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
            <a class="navbar-brand" href="index.html">General Service Office</a>


            </form>
            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ml-auto">


                <!-- User Dropdown-->
                <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="assets/img/1.jpg" /></a>
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="assets/img/1.jpg" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name">Sign Here!</div>
                                <div class="dropdown-user-details-email">cmu.edu.ph</div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#!">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Account Login
                        </a>

                    </div>
                </li>
            </ul>
        </nav>



            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <div class="container">
                            <div class="page-header-content pt-6">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-5">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"><i data-feather="layers"></i></div>
                                            GENERAL SERVICE OFFICE
                                        </h1>
                                        <div class="page-header-subtitle">WE DELIVER WHAT YOU COMMISSION</div>
                                    </div>
                                    <div class="col-12 col-xl-auto mt-4">
                                        <button class="btn btn-white p-3" id="reportrange">
                                            <i class="mr-2 text-primary" data-feather="calendar"></i>
                                            <span></span>
                                            <i class="ml-1" data-feather="chevron-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->


                    <div class="container mt-n10">

                        <div class="row justify-content-center">
                            <div class="col-xxl-8 col-xl-10 mb-4">
                                <div class="card h-auto">
                                    <div class="card-body d-flex flex-column justify-content-center py-5 py-xl-4">
                                        <div class="row align-items-center">
                                            <div class="col-xl-8 col-xxl-12">
                                                <div class="text-center text-xl-left text-xxl-center px-4 mb-4 mb-xl-0 mb-xxl-4">
                                                    <h1 class="text-primary">Welcome to GSO!</h1>
                                                    <p class="text-gray-700 mb-0">The General Service Office (GSO) typically has a goal of providing efficient and effective support services to the organization or company it serves. This can include managing office facilities, coordinating administrative functions, overseeing procurement processes, and ensuring that the organization's operational needs are met in a cost-effective manner. </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-xxl-12 text-center d-flex flex-column align-items-center">
                                              <div class="col-lg-4"><img class="img-fluid" src="assets/img/illustrations/problem-solving.svg" /></div>
                                              <a href="#contacts" class="btn btn-primary">Request a Quote</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="row justify-content-center">
                            <div class="col-xxl-8 col-xl-10 mb-4">
                                <div class="card h-auto">
                                    <div class="card-body d-flex flex-column justify-content-center py-5 py-xl-4">
                                        <div class="row align-items-center">
                                            <div class="col-lg-5 d-flex align-items-stretch">
                                                <div class="info">
                                                    <div class="address">
                                                        <i class="bi bi-geo-alt"></i>
                                                        <h4>Location:</h4>
                                                        <p>V362+285, Maramag, Bukidnon</p>
                                                    </div>

                                                    <div class="email">
                                                        <i class="bi bi-envelope"></i>
                                                        <h4>Email:</h4>
                                                        <p>info@example.com</p>
                                                    </div>

                                                    <div class="phone">
                                                        <i class="bi bi-phone"></i>
                                                        <h4>Call:</h4>
                                                        <p>+63 905 391 0403</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="map-container">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.974524277812!2d125.00002971460278!3d7.830166206334908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a19ef2f6bccecb%3A0x6314d748b7b1971f!2sV362%2B285%2C%20Maramag%2C%20Bukidnon!5e0!3m2!1sen!2sph!4v1649703720009!5m2!1sen!2sph" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <section id="contacts">
                            <div class="row justify-content-center">

                                <div class="col-xl-8">


                                    <!-- Account details card-->
                                    <div class="card mb-4">
                                        <div class="card-header">CONTACT INQUIRY HERE :</div>
                                        <div class="card-body">
                                            @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                            @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                            <form id="createContactForm" method="POST" action="{{ route('contacts.store') }}">
                                                @csrf <!-- CSRF protection -->
                                                <!-- Form Group (contact name)-->
                                                <div class="form-group">
                                                    <label class="small mb-1" for="Name">Identification</label>
                                                    <input class="form-control" id="name" type="text" placeholder="Enter your name" name="name" required>
                                                </div>
                                                <!-- Form Row-->
                                                <div class="form-row">
                                                     <!-- Form Group (contact email)-->
                                                     <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="email">Email </label>
                                                        <input class="form-control" id="email" type="email" placeholder="Enter your contact email address" name="email" required>
                                                    </div>

                                                    <!-- Form Group (unit cost)-->

                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="department">Department (Disregard if External)</label>
                                                        <input class="form-control" id="department" type="text" placeholder="Enter Department" name="department">
                                                    </div>
                                                </div>


                                               <!-- Form Group (request content)-->
                                               <div class="form-group ">
                                                <label class="small mb-1" for="requestContent">Request Content</label>
                                                <textarea class="form-control" id="content" placeholder="Enter your request content" name="content" required></textarea>
                                            </div>

                                               <!-- Save changes button-->
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    <span class="ml-auto" style="font-family: 'Times New Roman', serif; font-weight:  font-style: italic;">Wish to Check Your Progress? <a href="/contacts">Click Here!</a></span>

                                                </div>

                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>






                    </div>



                </main>
                <footer class="footer mt-auto footer-light">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; Your Website 2021</div>
                            <div class="col-md-6 text-md-right small">
                                <a href="#!">Privacy Policy</a>
                                &middot;
                                <a href="#!">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/date-range-picker-demo.js"></script>
    </body>
</html>
