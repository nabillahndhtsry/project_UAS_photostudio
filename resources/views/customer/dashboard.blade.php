@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')

<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-welcome-card">
                <div class="card-body">
                    <h3 class="text-dark">Selamat Datang, {{ Session::get('name') }}!</h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i> 
                                {{ now()->translatedFormat('l, d F Y') }}
                            </small>
                        </div>
                    </div>
                </div>
        
    

    <!-- Stats Cards - Minimal Version -->
    <div class="row fluid ms-3 me-3">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card dashboard-stats-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-calendar-check fa-2x icon"></i>
                    </div>
                    <h4 class="text-dark fw-bold dashboard-stats-number">{{ $stats['total_booking'] ?? 0 }}</h4>
                    <p class="text-dark dashboard-stats-label">Total Booking</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card dashboard-stats-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-clock fa-2x icon"></i>
                    </div>
                    <h4 class="text-dark fw-bold dashboard-stats-number">{{ $stats['pending'] ?? 0 }}</h4>
                    <p class="text-dark dashboard-stats-label">Pending</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card dashboard-stats-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-2x icon"></i>
                    </div>
                    <h4 class="text-dark fw-bold dashboard-stats-number">{{ $stats['selesai'] ?? 0 }}</h4>
                    <p class="text-dark dashboard-stats-label">Selesai</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card dashboard-stats-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-camera fa-2x icon"></i>
                    </div>
                    <h4 class="text-dark fw-bold dashboard-stats-number">{{ $stats['booking_aktif'] ?? 0 }}</h4>
                    <p class="text-dark dashboard-stats-label">Aktif</p>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
    </div>

    
    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12 mb-3">
            <h5 class="fw-bold text-dark">Aksi Cepat</h5>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-actions-card">
                <div class="card-body text-center p-4">
                    <i class="fas fa-plus-circle fa-2x mb-3 icon"></i>
                    <h6 class="fw-bold text-dark">Booking Baru</h6>
                    <p class="small text-muted mb-3">Pesan studio baru</p>
                    <a href="{{ route('customer.studio.list') }}" class="btn btn-utama btn-sm w-100">
                        Pilih Studio
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-actions-card">
                <div class="card-body text-center p-4">
                    <i class="fas fa-list fa-2x mb-3 icon"></i>
                    <h6 class="fw-bold text-dark">Booking Saya</h6>
                    <p class="small text-muted mb-3">Lihat semua booking</p>
                    <a href="{{ route('customer.booking.history') }}" class="btn btn-utama btn-sm w-100">
                        Lihat Booking
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-actions-card">
                <div class="card-body text-center p-4">
                    <i class="fas fa-credit-card fa-2x mb-3 icon"></i>
                    <h6 class="fw-bold text-dark">Pembayaran</h6>
                    <p class="small text-muted mb-3">Bayar & riwayat</p>
                    <a href="{{ route('customer.pembayaran') }}" class="btn btn-utama btn-sm w-100">
                        Bayar Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-actions-card">
                <div class="card-body text-center p-4">
                    <i class="fas fa-user fa-2x mb-3 icon"></i>
                    <h6 class="fw-bold text-dark">Akun Saya</h6>
                    <p class="small text-muted mb-3">Kelola profil</p>
                    <a href="#" class="btn btn-utama btn-sm w-100">
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card dashboard-table-card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark">Booking Terbaru</h5>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-utama">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($recent_bookings) && count($recent_bookings) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 dashboard-table">
                            <thead>
                                <tr>
                                    <th class="dashboard-table-header">Studio</th>
                                    <th class="dashboard-table-header">Tanggal</th>
                                    <th class="dashboard-table-header">Waktu</th>
                                    <th class="dashboard-table-header">Status</th>
                                    <th class="dashboard-table-header">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_bookings as $booking)
                                <tr class="dashboard-table-row align-middle">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($booking->gambar)
                                                <img src="{{ asset($booking->gambar) }}" 
                                                     class="rounded me-2" 
                                                     alt="{{ $booking->studio_name }}"
                                                     style="width: 30px; height: 30px; object-fit: cover;">
                                            @endif
                                            <span class="text-dark">{{ $booking->studio_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-dark">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</td>
                                    <td class="text-dark">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'dashboard-badge-warning',
                                                'disetujui' => 'badge-tersedia',
                                                'selesai' => 'badge-tersedia',
                                                'dibatalkan' => 'badge-tidak-tersedia'
                                            ][$booking->status_booking] ?? 'dashboard-badge-secondary';
                                        @endphp
                                        <span class="{{ $statusClass }}">
                                            {{ ucfirst($booking->status_booking) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.booking.detail', $booking->id) }}" 
                                           class="btn btn-sm btn-utama">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                        <h5 class="fw-bold text-dark">Belum Ada Booking</h5>
                        <p class="text-muted">Mulai booking studio pertama Anda</p>
                        <a href="{{ route('customer.studio.list') }}" class="btn btn-utama">
                            Booking Sekarang
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection