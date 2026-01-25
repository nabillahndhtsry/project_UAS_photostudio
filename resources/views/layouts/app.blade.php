<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Studiova</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.google.com/share?selection.family=Allerta|Andika:ital,wght@0,400;0,700;1,400;1,700|Lexend:wght@100..900|Monsieur+La+Doulaise|Nanum+Myeongjo|Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #610909;
            --secondary: #eb9c9c;
            --dark: #340909;
            --light: #faf8f8;
            --gradient: linear-gradient(180deg, #e5baba 25%, #340909 70%);
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #333;
            padding-top: 76px; /* Untuk fixed navbar */
        }
        
        .text-dark {
            color: var(--dark) !important;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--dark) !important;
        }
        
        .btn-logout {
            background: var(--dark);
            color: white;
            border: none;
            padding: 8px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: transform 0.3s;
        }
        
        
        .btn-login {
            background: var(--dark);
            color: white;
            border: none;
            padding: 8px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: transform 0.3s;
        }
        
        
        .btn-utama {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 8px;
            transition: transform 0.3s;
        }
        
        .btn-primary:hover {
        background: var(--dark);
        }
        
        .btn-warning {
        background: var(--primary);
        color: white;
        border: none;
        padding: 10px 25px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s;
        }

        .btn-warning:hover {
            background: var(--dark);
            color: white;
        }

        .btn-secondary {
            background: white;
            color: var(--dark);
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: var(--dark);
            color: white;
        }

        /* Badge untuk status studio */
        .badge-tersedia {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .badge-tidak-tersedia {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .section-padding {
            padding: 50px 0;
        }
        
        
        /* Hero Carousel Styles */
        .hero-section {
            position: relative;
            padding: 0;
        }

        .hero-slide {
            position: relative;
            width: 100%;
            height: 500px;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
        }

        /* Slide Background Images */
        .slide-1 {
            background: linear-gradient(180deg, rgba(115, 97, 89, 0.6) 30%, rgba(52, 9, 9, 0.96) 96%),
                        url('/images/studio/photo1.jpg');
        }

        .slide-2 {
            background: linear-gradient(180deg, rgba(115, 97, 89, 0.6) 30%, rgba(52, 9, 9, 0.96) 96%),
                        url('/images/studio/photo2.jpg');
        }

        .slide-3 {
            background: linear-gradient(180deg, rgba(115, 97, 89, 0.6) 30%, rgba(52, 9, 9, 0.96) 96%),
                        url('/images/studio/potrait1.jpg');
        }

        .slide-4 {
            background: linear-gradient(180deg, rgba(115, 97, 89, 0.6) 30%, rgba(52, 9, 9, 0.96) 96%),
                        url('/images/studio/potrait2.jpg');
        }

        /* PERHATIAN: Sesuaikan nama file slide-5 sesuai gambar yang Anda miliki */
        .slide-5 {
            background: linear-gradient(180deg, rgba(115, 97, 89, 0.6) 30%, rgba(52, 9, 9, 0.96) 96%),
                        url('/images/studio/photo2.jpg'); /* Ganti dengan nama file yang benar */
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: var(--dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .icon {
            color: var(--secondary);
        }


        .card-hover {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }
        
        .social-icons a {
            color: white;
            font-size: 1.2rem;
            margin-right: 15px;
            transition: color 0.3s;
        }
        
        .social-icons a:hover {
            color: var(--primary);
        }
        
        
    </style>
</head>
<body>
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-camera me-2"></i>PHOTOSTUDIOVA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#studios">Studios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Gallery</a>
                    </li>
                    
                    <!-- Jika sudah login, tampilkan dashboard -->
                    @if(Session::get('login'))
                        @if(Session::get('role') == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/dashboard">Admin Dashboard</a>
                            </li>
                        @else
                            <!-- Customer Dashboard dengan Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="/customer/dashboard" id="customerDashboardDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dashboard
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="customerDashboardDropdown">
                                    <li>
                                        <a class="dropdown-item" href="/customer/dashboard">
                                            <i class="fas fa-chart-line me-2"></i> Dashboard Utama
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.studio.list') }}">
                                            <i class="fas fa-plus-circle me-2"></i> Booking Baru
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.booking.history') }}">
                                            <i class="fas fa-list me-2"></i> Booking Saya
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.pembayaran') }}">
                                            <i class="fas fa-credit-card me-2"></i> Pembayaran
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.profile') }}">
                                            <i class="fas fa-user me-2"></i> Akun Saya
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item ms-3">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-logout">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <!-- Jika belum login, tampilkan tombol login -->
                        <li class="nav-item ms-3">
                            <a class="btn btn-login" href="{{ route('login') }}">
                                <i></i>Login
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3 class="mb-3"><i class="fas fa-camera me-2"></i>PHOTOSTUDIOVA</h3>
                    <p>We create high-performing digital designs that elevate brands and enhance conversions.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="mb-3">Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="#services" class="text-light text-decoration-none">Services</a></li>
                        <li><a href="#studios" class="text-light text-decoration-none">Studios</a></li>
                        <li><a href="#contact" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">Contact</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> Jakarta, Indonesia</p>
                    <p><i class="fas fa-phone me-2"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope me-2"></i> info@photostudiova.com</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">Business Hours</h5>
                    <p>Monday - Friday: 9AM - 8PM</p>
                    <p>Saturday: 10AM - 6PM</p>
                    <p>Sunday: 12PM - 5PM</p>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row mt-4">
                <div class="col-md-6">
                    <p>&copy; {{ date('Y') }} Photostudiova. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>Kelompok 1</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>