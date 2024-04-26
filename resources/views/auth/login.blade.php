{{-- @extends('layouts.app')

@section('content') --}}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login-Page</title>
            <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-teal">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                                <!-- Social login form-->
                                <div class="card my-5">
                                    <div class="card-body p-5 text-center">
                                        <div class="h3 font-weight-light mb-3">Sign In</div>
                                        <!-- Social login links-->
                                       <h2>GSO::CMU</h2>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body p-5">
                                        <!-- Login form-->
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <!-- Form Group (email address)-->
                                            <div class="form-group">
                                                <label class="text-gray-600 small" for="emailExample">Username</label>
                                                <input class="form-control form-control-solid" id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                            
                                                @error('name')
                                                <div class="alert alert-danger mb-0" id="errorAlert" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                <script>
                                                    setTimeout(function() {
                                                        document.getElementById('errorAlert').classList.add('show');
                                                        setTimeout(function() {
                                                            document.getElementById('errorAlert').classList.remove('show');
                                                        }, 3000); // 3000 milliseconds = 3 seconds
                                                    }, 1000); // 1000 milliseconds = 1 second
                                                </script>
                                                @enderror
                                            </div>
                                            <!-- Form Group (password)-->
                                            <div class="form-group">
                                                <label class="text-gray-600 small" for="password">Password</label>
                                                <input class="form-control form-control-solid" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                            
                                                @error('password')
                                                <div class="alert alert-danger mb-0" id="passwordErrorAlert" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                <script>
                                                    setTimeout(function() {
                                                        document.getElementById('passwordErrorAlert').classList.add('show');
                                                        setTimeout(function() {
                                                            document.getElementById('passwordErrorAlert').classList.remove('show');
                                                        }, 3000); // 3000 milliseconds = 3 seconds
                                                    }, 1000); // 1000 milliseconds = 1 second
                                                </script>
                                                @enderror
                                            </div>
                                            
                                            
                                    
                                                <div class="row mb-0">
                                                    <div class="col-md-8 offset-md-10">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Login') }}
                                                        </button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr class="my-2" /></hr>
                                    <div class="card-body px-6 py-4">
                                        <div class="small text-center">
                                            Have an account?
                                            <a href="register">Sign up!</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer mt-auto footer-dark">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; Your Website 2024</div>
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
        <script>
            .alert {
    opacity: 0;
    transition: opacity 0.5s;
}

.alert.show {
    opacity: 1;
}
            </script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
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
{{-- @endsection --}}