@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><b>Form Booking Studio</b></h2>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('customer.booking.store') }}" method="POST">
                @csrf
                
                <!-- Data Studio -->
                <input type="hidden" name="studio_id" value="{{ $studio->id }}">
                
                <div class="form-group mb-3">
                    <label>Studio</label>
                    <input type="text" class="form-control" value="{{ $studio->nama }}" readonly>
                </div>
                
                <div class="form-group mb-3">
                    <label>Harga per Jam</label>
                    <input type="text" class="form-control" 
                           value="Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}" readonly>
                </div>
                
                <!-- Form Input -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Booking*</label>
                            <input type="date" name="tanggal_booking" class="form-control" 
                                   min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jam Mulai*</label>
                            <input type="time" name="jam_mulai" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jam Selesai*</label>
                            <input type="time" name="jam_selesai" class="form-control" required>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="text-center">
                    <a href="{{ route('customer.studio.list') }}" class="btn btn-secondary mr-2">Kembali</a>
                    <button type="submit" class="btn btn-utama">Booking Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection