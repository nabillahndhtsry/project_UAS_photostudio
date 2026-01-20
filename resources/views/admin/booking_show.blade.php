<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking - Admin</title>
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
                <div class="card booking-detail-card">
                    <div class="card-header booking-detail-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white">
                            <i class="fas fa-calendar-alt me-2"></i>Detail Booking #{{ $booking->id }}
                        </h4>
                        <div>
                            @if($booking->status_booking == 'pending')
                                <span class="booking-badge-warning">Pending</span>
                            @elseif($booking->status_booking == 'disetujui')
                                <span class="booking-badge-success">Disetujui</span>
                            @elseif($booking->status_booking == 'selesai')
                                <span class="booking-badge-info">Selesai</span>
                            @else
                                <span class="booking-badge-danger">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Informasi Customer -->
                            <div class="col-md-6">
                                <div class="booking-info-card">
                                    <h5 class="booking-info-title">
                                        <i class="fas fa-user-circle me-2"></i> Informasi Customer
                                    </h5>
                                    <hr class="booking-info-hr">
                                    <p><strong>Nama:</strong> <span class="text-dark">{{ $booking->name }}</span></p>
                                    <p><strong>Email:</strong> <span class="text-dark">{{ $booking->email }}</span></p>
                                    <p><strong>Telepon:</strong> <span class="text-dark">{{ $booking->phone ?? '-' }}</span></p>
                                    <p><strong>Tanggal Booking:</strong> <span class="text-dark">{{ date('d/m/Y', strtotime($booking->created_at)) }}</span></p>
                                </div>
                            </div>

                            <!-- Informasi Studio -->
                            <div class="col-md-6">
                                <div class="booking-info-card">
                                    <h5 class="booking-info-title">
                                        <i class="fas fa-building me-2"></i> Informasi Studio
                                    </h5>
                                    <hr class="booking-info-hr">
                                    <p><strong>Studio:</strong> <span class="text-dark">{{ $booking->studio_name }}</span></p>
                                    <p><strong>Kapasitas:</strong> <span class="text-dark">{{ $booking->kapasitas }} orang</span></p>
                                    <p><strong>Harga per Jam:</strong> <span class="text-dark">Rp {{ number_format($booking->harga_per_jam, 0, ',', '.') }}</span></p>
                                    <p><strong>Deskripsi:</strong> <span class="text-dark">{{ $booking->deskripsi ?? '-' }}</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Jadwal & Biaya -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="booking-info-card">
                                    <h5 class="booking-info-title">
                                        <i class="fas fa-calendar-event me-2"></i> Jadwal & Biaya
                                    </h5>
                                    <hr class="booking-info-hr">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p><strong>Tanggal:</strong><br>
                                            <span class="text-dark">{{ date('d/m/Y', strtotime($booking->tanggal_booking)) }}</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Jam Mulai:</strong><br>
                                            <span class="text-dark">{{ $booking->jam_mulai }}</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Jam Selesai:</strong><br>
                                            <span class="text-dark">{{ $booking->jam_selesai }}</span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Durasi:</strong><br>
                                            <span class="text-dark">{{ $durasi_jam }} jam</span></p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="booking-cost-card">
                                                <h6 class="mb-0">Total Biaya: <strong class="text-dark">Rp {{ number_format($total_harga, 0, ',', '.') }}</strong></h6>
                                                <small class="text-muted">{{ $durasi_jam }} jam × Rp {{ number_format($booking->harga_per_jam, 0, ',', '.') }}/jam</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        @if($booking->status_booking == 'pending')
                                            <a href="/admin/booking/approve/{{ $booking->id }}" 
                                               class="btn booking-btn-success"
                                               onclick="return confirm('Setujui booking ini?')">
                                                <i class="fas fa-check-circle me-1"></i> Setujui
                                            </a>
                                            <a href="/admin/booking/cancel/{{ $booking->id }}" 
                                               class="btn booking-btn-danger"
                                               onclick="return confirm('Batalkan booking ini?')">
                                                <i class="fas fa-times-circle me-1"></i> Batalkan
                                            </a>
                                        @endif
                                        
                                        @if($booking->status_booking == 'disetujui')
                                            <a href="/admin/booking/complete/{{ $booking->id }}" 
                                               class="btn booking-btn-primary"
                                               onclick="return confirm('Tandai booking sebagai selesai?')">
                                                <i class="fas fa-check-all me-1"></i> Tandai Selesai
                                            </a>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <a href="/admin/booking" class="btn studio-btn-secondary">
                                            <i class="fas fa-arrow-left me-1"></i> Kembali
                                        </a>
                                        <a href="/admin/booking/delete/{{ $booking->id }}" 
                                           class="btn booking-btn-outline-danger"
                                           onclick="return confirm('Hapus permanen booking ini?')">
                                            <i class="fas fa-trash me-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>