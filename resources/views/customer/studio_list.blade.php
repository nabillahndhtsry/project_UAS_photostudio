@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-dark"><b>Daftar Studio Tersedia</b></h2>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(count($studios) > 0)
    <div class="row">
        @foreach($studios as $studio)
        <div class="col-md-4 mb-4">
            <div class="card studio-card h-100 shadow-sm">
                <!-- Gambar Studio -->
                @if($studio->gambar)
                    <img src="{{ asset($studio->gambar) }}" 
                        class="card-img-top" 
                        alt="{{ $studio->nama }}"
                        style="height: 220px; object-fit: cover;">
                @else
                    <span class="text-muted">No Image</span>
                @endif
               
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $studio->nama }}</h5>
                    
                    <!-- Status Badge -->
                    <div class="mb-2">
                        <span class="badge 
                            @if($studio->status == 'tersedia') badge-tersedia
                            @else bg-danger @endif">
                            {{ ucfirst($studio->status) }}
                        </span>
                        <span class="badge badge-tersedia ms-1">
                            <i class="fas fa-users"></i> Kapasitas: {{ $studio->kapasitas }}
                        </span>
                    </div>
                    
                    <!-- Deskripsi -->
                    <p class="card-text text-muted">
                        {{ Str::limit($studio->deskripsi, 100) }}
                    </p>
                    
                    <!-- Harga -->
                    <p class="fw-bold fs-5 text-dark">
                        Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}/jam
                    </p>
                    
                    <!-- Fasilitas (jika ada) -->
                    @if($studio->fasilitas)
                    <div class="mt-3">
                        <small class="text-muted">
                            Fasilitas: {{ Str::limit($studio->fasilitas, 50) }}
                        </small>
                    </div>
                    @endif
                </div>
                
                <div class="card-footer bg-white border-top-0">
                    <!-- Hanya bisa booking jika status tersedia -->
                    @if($studio->status == 'tersedia')
                    <a href="{{ route('customer.booking.create', $studio->id) }}" 
                    class="btn btn-utama btn-block w-100">
                        <i></i> Booking Sekarang
                    </a>
                    @else
                    <button class="btn btn-secondary btn-block w-100" disabled>
                        <i class="fas fa-ban me-2"></i> Tidak Tersedia
                    </button>
                    @endif
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle fa-2x mb-3"></i>
        <h5>Belum ada studio tersedia saat ini.</h5>
        <p class="mb-0">Silakan coba lagi nanti.</p>
    </div>
    @endif
</div>
@endsection