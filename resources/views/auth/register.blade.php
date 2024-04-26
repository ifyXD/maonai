<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin Pro</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-teal1">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container mb-10">
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-9">
                                <!-- Social registration form-->
                                <div class="card my-5">
                                    <div class="card-body p-5 text-center">
                                        <div class="h3 font-weight-light mb-3">Create an Account</div>
                                         <!-- Social registration links-->
                                     
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body p-5">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                        <div class="text-cent   er small text-muted mb-4">...or enter your information below.</div>
                                        <!-- Login form-->
                                                <form>
                                                <!-- Form Row-->
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <!-- Form Group (first name)-->
                                                        <div class="form-group">
                                                            <label for="ufname">{{ __('First Name') }}</label>
                                                            <input class="form-control form-control-solid" id="ufname" type="text" class="form-control @error('ufname') is-invalid @enderror" name="ufname" value="{{ old('ufname') }}" required autocomplete="ufname" autofocus>
                                                            
                                                            @error('ufname')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <!-- Form Group (last name)-->
                                                        <div class="form-group">
                                                            <label for="uname">{{ __('Middle Name(optional)') }}</label>
                                                            <input class="form-control form-control-solid" id="uname" type="text" class="form-control @error('uname') is-invalid @enderror" name="uname" value="{{ old('uname') }}"  autocomplete="uname" autofocus>
                                                            
                                                            @error('uname')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 ">
                                                        <!-- Form Group (last name)-->
                                                        <div class="form-group">
                                                            <label for="lname">{{ __('Last Name') }}</label>
                                                            <input class="form-control form-control-solid" id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="lname" autofocus>
                                                            
                                                            @error('lname')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <!-- Form Group (address)-->
                                                        <div class="form-group">
                                                            <label for="address">{{ __('Address') }}</label>
                                                            <input class="form-control form-control-solid @error('address') is-invalid @enderror" id="address" type="text" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>
                                                            @error('address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                <div class="col-md-6 ">
                                                    <!-- Form Group (last name)-->
                                                    <div class="form-group">
                                                <label for="contact" class="col-form-label">{{ __('Contact') }}</label>
                                                <input class="form-control form-control-solid" id="contact" type="number" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact" autofocus maxlength="11">
                                                @error('contact')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                                {{-- <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <label for="lname">{{ __('Office/Department') }}</label>
                                                    <input class="form-control form-control-solid" id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="lname" autofocus>
                                                    
                                                    @error('lname')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                </div> --}}
                                            </div>
                                            <!-- Form Group (email address)-->
                                            {{-- <div class="form-group">
                                                <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                                                <input class="form-control form-control-solid" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                       --}}

                                            <div class="form-group">
                                                <label for="username" class="col-form-label">{{ __('Username') }}</label>
                                                <input class="form-control form-control-solid" id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- Form Row-->
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <!-- Form Group (choose password)-->
                                                    <div class="form-group">
                                                        <label class="text-gray-600 small" for="passwordExample">Password</label>
                                                        <input class="form-control form-control-solid" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- Form Group (confirm password)-->
                                                    <div class="form-group">
                                                        <label class="text-gray-600 small" for="confirmPasswordExample">Confirm Password</label>
                                                        <input class="form-control form-control-solid" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Form Group (form submission)-->
                                            <div class="form-group d-flex align-items-center justify-content-between">
                                                <div class="custom-control custom-control-solid custom-checkbox">
                                                
                                                        
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Register') }}
                                                </button>
                                                </div>
                                        </form>
                                    </div>
                                    <hr class="my-2" /></hr>
                                    <div class="card-body px-6 py-4">
                                        <div class="small text-center">
                                            Have an account?
                                            <a href="login">Sign in!</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            {{-- <div id="layoutAuthentication_footer">
                <footer class="footer mt-auto footer-dark">
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
        </div> --}}
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
