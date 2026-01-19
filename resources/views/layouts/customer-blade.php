<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Studio - Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .navbar-custom { background-color: #6a11cb; }
        .studio-card { transition: transform 0.3s; border: 1px solid #ddd; }
        .studio-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .jumbotron-custom { background: linear-gradient(to right, #6a11cb, #2575fc); color: white; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-camera"></i> <b>STUDIO PHOTO</b>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><b>Home</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.studio') }}"><b>Studio</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.booking') }}"><b>Booking</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><b>Login Admin</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    <footer class="footer bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Kontak Kami</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Studio Photo No. 123</p>
                    <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@studiophoto.com</p>
                </div>
                <div class="col-md-6 text-right">
                    <p>&copy; {{ date('Y') }} - Photo Studio Booking</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>