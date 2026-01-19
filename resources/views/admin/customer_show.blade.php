<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Customer - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/admin/dashboard">Photo Studio Admin</a>
            <div class="navbar-text text-light">
                {{ Session::get('name') }} | 
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
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Detail Customer: {{ $customer->name }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Customer -->
                        <div class="mb-4">
                            <h5>Informasi Customer</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama Lengkap:</strong> {{ $customer->name }}</p>
                                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                                    <p><strong>Telepon:</strong> {{ $customer->phone ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Alamat:</strong> {{ $customer->address ?? '-' }}</p>
                                    <p><strong>Tanggal Daftar:</strong> {{ date('d/m/Y H:i', strtotime($customer->created_at)) }}</p>
                                    <p><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Customer -->
                        <div class="mb-4">
                            <h5>Statistik Customer</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card text-white bg-info mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Booking</h5>
                                            <p class="card-text display-6">{{ $stats['total_booking'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-white bg-warning mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Booking Aktif</h5>
                                            <p class="card-text display-6">{{ $stats['booking_aktif'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-white bg-success mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Pembayaran</h5>
                                            <p class="card-text">Rp {{ number_format($stats['total_pembayaran'], 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Customer ID</h5>
                                            <p class="card-text">#{{ $customer->id }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Booking Terbaru -->
                        <div class="mb-4">
                            <h5>Riwayat Booking Terbaru</h5>
                            @if($bookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Studio</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Status Booking</th>
                                            <th>Status Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->studio_name }}</td>
                                                <td>{{ date('d/m/Y', strtotime($booking->tanggal_booking)) }}</td>
                                                <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                                                <td>
                                                    @if($booking->status_booking == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($booking->status_booking == 'disetujui')
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @elseif($booking->status_booking == 'selesai')
                                                        <span class="badge bg-primary">Selesai</span>
                                                    @else
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($booking->status_bayar == 'lunas')
                                                        <span class="badge bg-success">Lunas</span>
                                                    @elseif($booking->status_bayar == 'belum_lunas')
                                                        <span class="badge bg-warning">Belum Lunas</span>
                                                    @else
                                                        <span class="badge bg-secondary">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Customer ini belum memiliki riwayat booking.
                            </div>
                            @endif
                        </div>

                        <!-- Tombol Kembali -->
                        <div class="d-flex justify-content-between">
                            <a href="/admin/customer" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                            </a>
                            
                            <div>
                                <button class="btn btn-outline-info" onclick="window.print()">
                                    <i class="bi bi-printer"></i> Cetak
                                </button>
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