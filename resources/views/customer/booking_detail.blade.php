@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 fw-bold text-dark"><i class="fas fa-receipt me-2"></i>Detail Booking</h2>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Booking Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="fw-bold text-dark">Kode Booking</h5>
                            <p class="text-muted">BK{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-dark">Status</h5>
                            <p>
                                <span class="badge @if($booking->status_booking == 'pending') badge-tidak-tersedia
                                               @elseif($booking->status_booking == 'disetujui') badge-tersedia
                                               @elseif($booking->status_booking == 'selesai') badge-tersedia
                                               @else badge-tidak-tersedia @endif">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status_booking)) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Studio Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark">Studio</h6>
                            <p class="text-muted">{{ $booking->studio_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark">Harga per Jam</h6>
                            <p class="text-muted">Rp {{ number_format($booking->harga_per_jam, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <!-- Booking Schedule -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <h6 class="fw-bold text-dark">Tanggal</h6>
                            <p class="text-muted">{{ date('d M Y', strtotime($booking->tanggal_booking)) }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold text-dark">Jam Mulai</h6>
                            <p class="text-muted">{{ date('H:i', strtotime($booking->jam_mulai)) }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold text-dark">Jam Selesai</h6>
                            <p class="text-muted">{{ date('H:i', strtotime($booking->jam_selesai)) }}</p>
                        </div>
                    </div>
                    
                    <!-- Duration & Total -->
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark">Durasi</h6>
                            <p class="text-muted">{{ $durasi_jam }} jam</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark">Total Bayar</h6>
                            <p class="h5 fw-bold text-dark">Rp {{ number_format($durasi_jam * $booking->harga_per_jam, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Status Card -->
            @if($booking->status_bayar)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="fw-bold text-dark mb-0"><i class="fas fa-credit-card me-2"></i>Status Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark">Status</h6>
                            <p>
                                <span class="badge @if($booking->status_bayar == 'lunas') badge-tersedia @else badge-tidak-tersedia @endif">
                                    {{ $booking->status_bayar == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark">Metode Pembayaran</h6>
                            <p class="text-muted">{{ ucfirst($booking->metode_bayar ?? '-') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="row mt-4 mb-5">
                <div class="col-md-12">
                    @if($booking->status_booking == 'pending')
                    <form action="{{ route('customer.booking.cancel', $booking->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn badge-tidak-tersedia me-2" onclick="return confirm('Yakin ingin membatalkan booking?')">
                            <i class="fas fa-times me-2"></i>Batalkan Booking
                        </button>
                    </form>
                    @endif
                    
                    <a href="{{ route('customer.booking.history') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection