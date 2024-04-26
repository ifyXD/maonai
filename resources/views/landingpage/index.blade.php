<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page :: GSO</title>

    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">
    


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <button class="navbar-toggle" onclick="toggleNavbar()">
        <span class="hamburger"></span>
        <span class="hamburger"></span>
        <span class="hamburger"></span>
    </button>
    <header>
        <div class="container">
            <div class="navbar">
                <div class="navbar-brand">
                    <h3>GSO</h3>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav">
                        <li><a href="">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Team</a></li>
                        <li><a href="{{route('welcome')}}">Contact</a></li>
                    </ul>
                    <div class="navbar-nav">
                        <ul>
                            <li><a href="{{route('login')}}">Login</a></li>
                        </ul>
    
                        <button onclick="window.location.href = '{{ route('register') }}';">Register Now</button>
    
                    </div>
                </div>
            </div>
        </div>
    
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h5>For Better Future</h5>
                    <h1> Managing and Maintaining Office Services</h1>
                    <h4>A General Services Office provides support for office management </h4>
    
                    <div class="cta">
                        <button onclick="window.location.href = '{{ route('login') }}';">Request a Quote</button>
                        <button onclick="window.location.href = '{{ route('welcome') }}';">Learn More</button>
                    </div>
    
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                 <img class="img-fluid px-xl-4 mt-xxl-n5" src="assets/img/illustrations/statistics.svg" /></div>

                </div>
            </div>
        </div>
        
    </header>

<script>
    function toggleNavbar() {
    var navbar = document.querySelector('.navbar-nav');
    var navbarToggle = document.querySelector('.navbar-toggle');
    navbar.classList.toggle('active');
    navbarToggle.classList.toggle('active');
}

</script>
</body>
</html>