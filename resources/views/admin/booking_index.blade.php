<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Booking - Admin</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="booking-page-title">
                <i class="fas fa-calendar-check me-2"></i>Data Booking Studio
            </h2>
            
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success booking-alert alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger booking-alert alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($bookings->count() > 0)
        <div class="card booking-table-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover booking-table">
                        <thead>
                            <tr>
                                <th class="booking-table-header">#</th>
                                <th class="booking-table-header">Customer</th>
                                <th class="booking-table-header">Studio</th>
                                <th class="booking-table-header">Tanggal & Jam</th>
                                <th class="booking-table-header">Status Booking</th>
                                <th class="booking-table-header">Status Bayar</th>
                                <th class="booking-table-header">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                @php
                                    $jam_mulai = strtotime($booking->jam_mulai);
                                    $jam_selesai = strtotime($booking->jam_selesai);
                                    $durasi_jam = round(($jam_selesai - $jam_mulai) / 3600, 1);
                                    $total_harga = $durasi_jam * $booking->harga_per_jam;
                                @endphp
                                <tr class="booking-table-row">
                                    <td class="booking-table-cell">{{ $loop->iteration }}</td>
                                    <td class="booking-table-cell">
                                        <strong class="text-dark">{{ $booking->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $booking->email }}</small>
                                    </td>
                                    <td class="booking-table-cell text-dark">{{ $booking->studio_name }}</td>
                                    <td class="booking-table-cell">
                                        <small><strong class="text-dark">{{ date('d/m/Y', strtotime($booking->tanggal_booking)) }}</strong></small><br>
                                        <small class="text-dark">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</small><br>
                                        <small class="text-muted">{{ $durasi_jam }} jam (Rp {{ number_format($total_harga, 0, ',', '.') }})</small>
                                    </td>
                                    <td class="booking-table-cell">
                                        @if($booking->status_booking == 'pending')
                                            <span class="booking-badge-warning">Pending</span>
                                        @elseif($booking->status_booking == 'disetujui')
                                            <span class="booking-badge-success">Disetujui</span>
                                        @elseif($booking->status_booking == 'selesai')
                                            <span class="booking-badge-info">Selesai</span>
                                        @else
                                            <span class="booking-badge-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="booking-table-cell">
                                        @if($booking->status_bayar == 'lunas')
                                            <span class="booking-badge-success">LUNAS</span>
                                        @else
                                            <span class="booking-badge-warning">BELUM LUNAS</span>
                                        @endif
                                    </td>
                                    <td class="booking-table-cell">
                                        @if($booking->status_booking == 'pending')
                                            <form action="/admin/booking/approve/{{ $booking->id }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm booking-btn-success" 
                                                        onclick="return confirm('Setujui booking ini?')">
                                                    <i class="fas fa-check-circle me-1"></i> Terima
                                                </button>
                                            </form>
                                            <form action="/admin/booking/cancel/{{ $booking->id }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm booking-btn-danger" 
                                                        onclick="return confirm('Tolak booking ini?')">
                                                    <i class="fas fa-times-circle me-1"></i> Tolak
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($booking->status_booking == 'disetujui')
                                            <form action="/admin/booking/complete/{{ $booking->id }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm booking-btn-primary" 
                                                        onclick="return confirm('Tandai booking sebagai selesai?')">
                                                    Selesai
                                                </button>
                                            </form>
                                        @endif

                                        <form action="/admin/booking/delete/{{ $booking->id }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm booking-btn-outline-danger" 
                                                    onclick="return confirm('Hapus permanen booking ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <a href="/admin/booking/{{ $booking->id }}" class="btn payment-btn-info" title="Detail">
                                            <i class="fas fa-eye me-1"></i>                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning booking-alert">
            <i class="fas fa-info-circle me-2"></i> Belum ada data booking.
        </div>
        @endif

        <div class="mt-3">
            <a href="/admin/dashboard" class="btn studio-btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>