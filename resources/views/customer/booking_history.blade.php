@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <h2 class="text-dark mb-4"><b>Riwayat Booking Saya</b></h2>
    
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
    
    @if(count($bookings) > 0)
        <div class="table-responsive text-dark">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Studio</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status Booking</th>
                        <th>Status Bayar</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    @foreach($bookings as $booking)
                    <tr class="align-middle">
                        <td>{{ $booking->studio_name }}</td>
                        <td>{{ date('d/m/Y', strtotime($booking->tanggal_booking)) }}</td>
                        <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                        <td class="font-">
                            @php
                                $statusClass = [
                                    'pending' => 'badge-tidak-tersedia',
                                    'disetujui' => 'badge-tersedia',
                                    'selesai' => 'badge-tersedia',
                                    'dibatalkan' => 'badge-tidak-tersedia'
                                ][$booking->status_booking] ?? 'badge bg-secondary';
                            @endphp
                            <span class="{{ $statusClass }}">
                                {{ ucfirst($booking->status_booking) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $paymentClass = [
                                    'lunas' => 'badge-tersedia',
                                    'belum_lunas' => 'badge-tidak-tersedia'
                                ][$booking->status_bayar] ?? 'badge bg-secondary';
                            @endphp
                            <span class="{{ $paymentClass }}">
                                {{ $booking->status_bayar ? ucfirst(str_replace('_', ' ', $booking->status_bayar)) : '-' }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($booking->total_bayar ?? 0, 0, ',', '.') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('customer.booking.detail', $booking->id) }}" 
                                   class="btn btn-utama" title="Lihat Detail">
                                   <i class="fas fa-eye"></i>
                                </a>
                                @if($booking->status_bayar == 'belum_lunas')
                                    <a href="{{ route('customer.invoice', $booking->id) }}" 
                                       class="btn btn-info" target="_blank" title="Lihat Invoice">
                                       <i class="fas fa-file-pdf"></i>
                                    </a>
                                @endif
                                @if($booking->status_booking == 'pending' && $booking->status_bayar == 'belum_lunas')
                                    <a href="{{ route('customer.pembayaran') }}" 
                                       class="btn btn-success" title="Bayar Sekarang">
                                       <i class="fas fa-money-bill"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $bookings->links() }}
        </div>
    @else
        <div class="alert alert-info">
            <p class="mb-0">Belum ada booking.</p>
        </div>
    @endif
    <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
@endsection