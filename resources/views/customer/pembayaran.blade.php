@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 fw-bold text-dark">
                <i class="fas fa-credit-card me-2"></i>Konfirmasi Pembayaran
            </h2>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Booking</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td><strong>Studio</strong></td>
                            <td>{{ $bookingData['studio_name'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $bookingData['tanggal'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Waktu</strong></td>
                            <td>{{ $bookingData['jam_mulai'] }} - {{ $bookingData['jam_selesai'] }} ({{ $bookingData['durasi'] }})</td>
                        </tr>
                        <tr>
                            <td><strong>Harga per Jam</strong></td>
                            <td>Rp {{ number_format($bookingData['harga_per_jam'], 0, ',', '.') }}</td>
                        </tr>
                        <tr style="border-top: 2px solid #ddd;">
                            <td><strong>Total Pembayaran</strong></td>
                            <td><strong class="text-danger" style="font-size: 18px;">Rp {{ number_format($bookingData['total'], 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Pilih Metode Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.payment.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $bookingData['id'] }}">

                        <div class="mb-4">
                            <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode_bayar" id="transfer" value="transfer" required onchange="togglePaymentProof()">
                                        <label class="form-check-label" for="transfer">
                                            <i class="fas fa-university me-2"></i><strong>Transfer Bank</strong>
                                            <br><small class="text-muted">Transfer ke rekening studio</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode_bayar" id="ewallet" value="ewallet" onchange="togglePaymentProof()">
                                        <label class="form-check-label" for="ewallet">
                                            <i class="fas fa-wallet me-2"></i><strong>E-Wallet</strong>
                                            <br><small class="text-muted">GCash, GrabPay, dll</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode_bayar" id="tunai" value="tunai" onchange="togglePaymentProof()">
                                        <label class="form-check-label" for="tunai">
                                            <i class="fas fa-money-bill-wave me-2"></i><strong>Tunai</strong>
                                            <br><small class="text-muted">Bayar saat hari booking</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Bukti Pembayaran -->
                        <div class="mb-4" id="paymentProofSection" style="display: none;">
                            <div class="card border-warning bg-light">
                                <div class="card-body">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-receipt me-2 text-warning"></i>Upload Bukti Pembayaran
                                    </label>
                                    <small class="d-block text-muted mb-3">
                                        Mohon upload bukti pembayaran (screenshot atau foto). Format: JPG, PNG, PDF. Maksimal 5MB.
                                    </small>
                                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                    @error('bukti_pembayaran')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-lightbulb me-2"></i><strong>Catatan:</strong> Setelah mengklik "Konfirmasi Pembayaran", Anda akan mendapatkan invoice yang dapat diunduh dan dicetak.
                        </div>

                        <div class="d-flex gap-2 justify-content-between">
                            <a href="{{ session('from_welcome') ? '/' : route('customer.studio.list') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-utama" style="background-color: #610909; color: white;">
                                <i class="fas fa-check me-2"></i>Konfirmasi Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePaymentProof() {
    const metode = document.querySelector('input[name="metode_bayar"]:checked').value;
    const proofSection = document.getElementById('paymentProofSection');
    const proofInput = document.getElementById('bukti_pembayaran');
    
    if (metode === 'transfer' || metode === 'ewallet') {
        proofSection.style.display = 'block';
        proofInput.required = true;
    } else {
        proofSection.style.display = 'none';
        proofInput.required = false;
        proofInput.value = '';
    }
}
</script>
@endsection