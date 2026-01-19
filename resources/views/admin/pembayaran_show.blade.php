<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran - Admin</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="body">
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

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card payment-table-card">
                    <div class="card-header payment-table-header">
                        <h4 class="mb-0 text-light">
                            <i class="fas fa-credit-card me-2 r"></i>Detail Pembayaran #{{ $pembayaran->id }}
                        </h4>
                    </div>
                    <div class="card-body">
                        
                        @if(Session::has('success'))
                            <div class="alert alert-success payment-alert alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>{{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Informasi Pembayaran -->
                        <div class="mb-4">
                            <h5 class="payment-page-title">
                                <i class="fas fa-info-circle me-2"></i>Informasi Pembayaran
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="payment-detail-item">
                                        <strong>Status:</strong> 
                                        @if($pembayaran->status_bayar == 'lunas')
                                            <span class="payment-badge-status-success">LUNAS</span>
                                        @else
                                            <span class="payment-badge-status-warning">BELUM LUNAS</span>
                                        @endif
                                    </p>
                                    <p class="payment-detail-item">
                                        <strong>Total Bayar:</strong> 
                                        <strong class="text-dark">Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}</strong>
                                    </p>
                                    <p class="payment-detail-item">
                                        <strong>Metode Bayar:</strong> 
                                        @if($pembayaran->metode_bayar == 'transfer')
                                            <span class="payment-badge-method-info">Transfer</span>
                                        @elseif($pembayaran->metode_bayar == 'tunai')
                                            <span class="payment-badge-method-success">Tunai</span>
                                        @else
                                            <span class="payment-badge-method-primary">E-Wallet</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="payment-detail-item">
                                        <strong>Tanggal Bayar:</strong> 
                                        <span class="text-dark">{{ $pembayaran->tanggal_bayar ? date('d/m/Y', strtotime($pembayaran->tanggal_bayar)) : '-' }}</span>
                                    </p>
                                    <p class="payment-detail-item">
                                        <strong>Tanggal Dibuat:</strong> 
                                        <span class="text-dark">{{ date('d/m/Y H:i', strtotime($pembayaran->created_at)) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Customer -->
                        <div class="mb-4">
                            <h5 class="payment-page-title">
                                <i class="fas fa-user me-2"></i>Informasi Customer
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="payment-detail-item">
                                        <strong>Nama:</strong> 
                                        <span class="text-dark">{{ $pembayaran->customer_name }}</span>
                                    </p>
                                    <p class="payment-detail-item">
                                        <strong>Email:</strong> 
                                        <span class="text-dark">{{ $pembayaran->email }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="payment-detail-item">
                                        <strong>Telepon:</strong> 
                                        <span class="text-dark">{{ $pembayaran->phone ?? '-' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Booking -->
                        <div class="mb-4">
                            <h5 class="payment-page-title">
                                <i class="fas fa-calendar-alt me-2"></i>Informasi Booking
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="payment-detail-item">
                                        <strong>Studio:</strong> 
                                        <span class="text-dark">{{ $pembayaran->studio_name }}</span>
                                    </p>
                                    <p class="payment-detail-item">
                                        <strong>Tanggal Booking:</strong> 
                                        <span class="text-dark">{{ date('d/m/Y', strtotime($pembayaran->tanggal_booking)) }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="payment-detail-item">
                                        <strong>Jam:</strong> 
                                        <span class="text-dark">{{ $pembayaran->jam_mulai }} - {{ $pembayaran->jam_selesai }}</span>
                                    </p>
                                    <p class="payment-detail-item">
                                        <strong>Durasi:</strong> 
                                        <span class="text-dark">{{ $durasi_jam }} jam</span>
                                    </p>
                                </div>
                            </div>
                            <div class="alert payment-status-alert mt-3">
                                <i class="fas fa-calculator me-2"></i>
                                <strong>Perhitungan:</strong> {{ $durasi_jam }} jam × Rp {{ number_format($pembayaran->harga_per_jam, 0, ',', '.') }}/jam 
                                = Rp {{ number_format($total_harga, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="/admin/pembayaran" class="btn studio-btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            
                            @if($pembayaran->status_bayar == 'belum_lunas')
                                <form action="{{ route('admin.pembayaran.confirm', $pembayaran->id) }}" 
                                   method="POST"
                                   class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn payment-btn-success"
                                            onclick="return confirm('Konfirmasi pembayaran ini sebagai LUNAS?')">
                                        <i class="fas fa-check-circle me-2"></i> Konfirmasi Lunas
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>