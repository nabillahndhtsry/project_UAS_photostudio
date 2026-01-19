<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Photo Studio</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.google.com/share?selection.family=Allerta|Andika:ital,wght@0,400;0,700;1,400;1,700|Lexend:wght@100..900|Monsieur+La+Doulaise|Nanum+Myeongjo|Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="body">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-navbar">
        <div class="container">
            <a class="navbar-brand dashboard-brand" href="/admin/dashboard">
                <i class="fas fa-camera me-2"></i>PHOTOSTUDIOVA <span class="dashboard-subtitle">Admin Panel</span>
            </a>
            <div class="navbar-text text-light">
                Login sebagai: <strong>{{ Session::get('name') }}</strong> | 
                
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn logout-btn">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-3">
                <!-- Menu sidebar -->
                <div class="list-group dashboard-sidebar">
                    <a href="/admin/dashboard" class="list-group-item list-group-item-action dashboard-menu-item active">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="/admin/studio" class="list-group-item list-group-item-action dashboard-menu-item">
                        <i class="fas fa-photo-video me-2"></i>Manajemen Studio
                    </a>
                    <a href="/admin/booking" class="list-group-item list-group-item-action dashboard-menu-item">
                        <i class="fas fa-calendar-check me-2"></i>Data Booking
                    </a>
                    <a href="/admin/pembayaran" class="list-group-item list-group-item-action dashboard-menu-item">
                        <i class="fas fa-credit-card me-2"></i>Data Pembayaran
                    </a>
                    <a href="/admin/customer" class="list-group-item list-group-item-action dashboard-menu-item">
                        <i class="fas fa-users me-2"></i>Data Customer
                    </a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="dashboard-content">
                    <h3 class="dashboard-welcome">Selamat Datang, Admin!</h3>
                    <p class="dashboard-subtext">Anda berhasil login sebagai Administrator.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card dashboard-card-primary mb-3">
                                <div class="card-body text-center">
                                    <div class="dashboard-card-icon">
                                        <i class="fas fa-photo-video"></i>
                                    </div>
                                    <h5 class="card-title dashboard-card-title">Total Studio</h5>
                                    <p class="card-text dashboard-card-number">{{ $total_studio ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card dashboard-card-success mb-3">
                                <div class="card-body text-center">
                                    <div class="dashboard-card-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <h5 class="card-title dashboard-card-title">Booking Hari Ini</h5>
                                    <p class="card-text dashboard-card-number">{{ $booking_hari_ini ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card dashboard-card-warning mb-3">
                                <div class="card-body text-center">
                                    <div class="dashboard-card-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <h5 class="card-title dashboard-card-title">Pending Payment</h5>
                                    <p class="card-text dashboard-card-number">{{ $pending_payment ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="/" class="btn studio-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>