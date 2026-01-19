@extends('layouts.app')

@section('title', 'Booking Studio')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 fw-bold text-dark"><i class="fas fa-calendar-check me-2"></i>Form Booking Studio</h2>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('customer.booking.store') }}" method="POST">
                        @csrf
                        
                        <!-- Hidden Studio ID -->
                        <input type="hidden" name="studio_id" value="{{ $studio->id }}">
                        
                        <!-- Studio Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Studio</label>
                                    <input type="text" class="form-control" value="{{ $studio->nama }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Harga per Jam</label>
                                    <input type="text" class="form-control" 
                                           value="Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Date & Time -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Tanggal Booking <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_booking" class="form-control" 
                                           min="{{ date('Y-m-d') }}" required
                                           @error('tanggal_booking') is-invalid @enderror>
                                    @error('tanggal_booking')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_mulai" class="form-control" required
                                           @error('jam_mulai') is-invalid @enderror>
                                    @error('jam_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_selesai" class="form-control" required
                                           @error('jam_selesai') is-invalid @enderror>
                                    @error('jam_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <a href="{{ route('customer.studio.list') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-utama">
                                    <i class="fas fa-check me-2"></i>Booking Sekarang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection