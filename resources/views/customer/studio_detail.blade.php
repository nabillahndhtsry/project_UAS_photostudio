@extends('layouts.app')

@section('title', 'Detail Studio')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <!-- Gambar Studio -->
            <div class="card mb-4">
                @if($studio->gambar)
                    <img src="{{ asset($studio->gambar) }}" class="card-img-top" alt="{{ $studio->nama }}" style="height: 400px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <!-- Informasi Studio -->
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title fw-bold mb-3">{{ $studio->nama }}</h2>
                    
                    <!-- Status -->
                    <div class="mb-3">
                        <span class="badge @if($studio->status == 'tersedia') bg-success @else bg-danger @endif">
                            {{ ucfirst($studio->status) }}
                        </span>
                    </div>
                    
                    <!-- Kapasitas -->
                    <div class="mb-3">
                        <p><strong><i class="fas fa-users me-2"></i> Kapasitas:</strong> {{ $studio->kapasitas }} orang</p>
                    </div>
                    
                    <!-- Harga -->
                    <div class="mb-3">
                        <p class="h4 fw-bold text-dark">Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}/jam</p>
                    </div>
                    
                    <!-- Booking Button -->
                    @if($studio->status == 'tersedia')
                        <a href="{{ route('customer.booking.create', $studio->id) }}" class="btn btn-utama btn-lg w-100">
                            Booking Sekarang
                        </a>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="fas fa-ban me-2"></i> Tidak Tersedia
                        </button>
                    @endif
                    
                    <!-- Kembali -->
                    <a href="{{ session('from_welcome') ? '/' : route('customer.studio.list') }}" class="btn btn-outline-secondary btn-lg w-100 mt-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Deskripsi Lengkap -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Deskripsi</h5>
                    <p class="card-text">{{ $studio->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fasilitas -->
    @if($studio->fasilitas)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Fasilitas</h5>
                    <p class="card-text">{{ $studio->fasilitas }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Jadwal Booking yang Sudah Terpakai -->
    <div class="row mt-4 mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Jadwal yang Sudah Dibooking</h5>
                    @if(count($booked_slots) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booked_slots as $slot)
                                    <tr>
                                        <td>{{ date('d M Y', strtotime($slot->tanggal_booking)) }}</td>
                                        <td>{{ date('H:i', strtotime($slot->jam_mulai)) }}</td>
                                        <td>{{ date('H:i', strtotime($slot->jam_selesai)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Studio ini belum memiliki jadwal booking.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection