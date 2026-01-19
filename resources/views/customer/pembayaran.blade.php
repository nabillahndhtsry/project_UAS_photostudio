@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Konfirmasi Pembayaran</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form action="{{ route('customer.payment.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $bookingData['id'] }}">
        
        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode_bayar" class="form-control" required>
                <option value="transfer">Transfer Bank</option>
                <option value="ewallet">E-Wallet</option>
                <option value="tunai">Tunai</option>
            </select>
        </div>
        
        
        <button type="submit" class="btn btn-utama">Konfirmasi Pembayaran</button>
    </form>
</div>
@endsection