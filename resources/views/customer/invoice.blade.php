<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $bookingData['kode_booking'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 10px;
        }
        .invoice-page {
            width: 210mm;
            height: 297mm;
            background: white;
            margin: 10px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            font-size: 12px;
            line-height: 1.4;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            border-bottom: 2px solid #610909;
            padding-bottom: 10px;
        }
        .invoice-title {
            color: #610909;
            font-weight: bold;
            font-size: 20px;
        }
        .invoice-code {
            text-align: right;
            font-size: 11px;
        }
        .invoice-code strong {
            display: block;
            color: #610909;
            font-weight: bold;
        }
        .content-section {
            margin-bottom: 12px;
        }
        .section-title {
            color: #340909;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            margin-bottom: 6px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            border-bottom: 1px dotted #eee;
            font-size: 11px;
        }
        .info-label {
            font-weight: 600;
            width: 50%;
        }
        .info-value {
            text-align: right;
            width: 50%;
        }
        .total-section {
            background-color: #f9f9f9;
            padding: 8px;
            border-radius: 3px;
            margin: 10px 0;
            border-left: 3px solid #610909;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            font-size: 11px;
        }
        .total-amount {
            color: #610909;
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #ddd;
            padding-top: 3px;
            margin-top: 3px;
        }
        .footer-note {
            font-size: 10px;
            color: #666;
            margin-top: 15px;
            padding: 8px;
            background-color: #fafafa;
            border-radius: 3px;
            line-height: 1.3;
        }
        .footer {
            text-align: center;
            font-size: 9px;
            color: #999;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        .invoice-status {
            display: inline-block;
            padding: 2px 8px;
            background-color: #ffc107;
            color: white;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .button-section {
            text-align: center;
            margin-top: 20px;
        }
        button {
            background-color: #610909;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover {
            background-color: #340909;
        }
        .back-link {
            text-align: center;
            margin-top: 10px;
        }
        .back-link a {
            color: #610909;
            text-decoration: none;
            font-size: 14px;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .invoice-page {
                width: 100%;
                height: auto;
                margin: 0;
                padding: 20px;
                box-shadow: none;
                page-break-after: avoid;
            }
            button, .back-link {
                display: none;
            }
            .button-section {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-page">
        <!-- Header -->
        <div class="invoice-header">
            <div>
                <div class="invoice-title">INVOICE</div>
                <div style="font-size: 10px; color: #666;">PHOTOSTUDIOVA</div>
            </div>
            <div class="invoice-code">
                <strong>{{ $bookingData['kode_booking'] }}</strong>
                <div>{{ date('d/m/Y') }}</div>
            </div>
        </div>

        <!-- Detail Studio & Booking -->
        <div class="content-section">
            <div class="section-title">Studio & Booking</div>
            <div class="info-row">
                <span class="info-label">Studio:</span>
                <span class="info-value">{{ $bookingData['studio_name'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Booking:</span>
                <span class="info-value">{{ $bookingData['tanggal'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jam:</span>
                <span class="info-value">{{ $bookingData['jam_mulai'] }} - {{ $bookingData['jam_selesai'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Durasi:</span>
                <span class="info-value">{{ $bookingData['durasi'] }}</span>
            </div>
        </div>

        <!-- Detail Biaya -->
        <div class="content-section">
            <div class="section-title">Detail Biaya</div>
            <div class="info-row">
                <span class="info-label">Harga per Jam:</span>
                <span class="info-value">Rp {{ number_format($bookingData['harga_per_jam'], 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jumlah Jam:</span>
                <span class="info-value">{{ explode(' ', $bookingData['durasi'])[0] }} jam</span>
            </div>
            <div class="total-section">
                <div class="total-row">
                    <span class="info-label">Subtotal:</span>
                    <span class="info-value">Rp {{ number_format($bookingData['total'], 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span class="info-label">Pajak:</span>
                    <span class="info-value">Rp 0</span>
                </div>
                <div class="total-row total-amount">
                    <span>Total:</span>
                    <span>Rp {{ number_format($bookingData['total'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Informasi Customer & Pembayaran -->
        <div style="display: flex; gap: 15px;">
            <div class="content-section" style="flex: 1;">
                <div class="section-title">Pemesan</div>
                <div class="info-row">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $customerData['name'] ?? 'Customer' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ substr($customerData['email'] ?? '-', 0, 20) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Telepon:</span>
                    <span class="info-value">{{ $customerData['phone'] ?? '-' }}</span>
                </div>
            </div>
            <div class="content-section" style="flex: 1;">
                <div class="section-title">Pembayaran</div>
                <div class="info-row">
                    <span class="info-label">Metode:</span>
                    <span class="info-value">
                        @if($paymentData['metode_bayar'] == 'transfer')
                            Transfer
                        @elseif($paymentData['metode_bayar'] == 'ewallet')
                            E-Wallet
                        @else
                            Tunai
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="invoice-status">
                            @if($paymentData['status_bayar'] == 'lunas')
                                Lunas
                            @else
                                Belum Lunas
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Catatan -->
        <div class="footer-note">
            <strong>Catatan:</strong> Pembayaran harus diselesaikan sebelum tanggal booking. Untuk transfer bank dan e-wallet, mohon upload bukti pembayaran melalui dashboard.
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah memilih PHOTOSTUDIOVA</p>
            <p>Invoice dibuat pada: {{ date('d M Y H:i') }}</p>
        </div>
    </div>

    <!-- Print Button -->
    <div class="button-section">
        <button onclick="window.print()">
            <i class="fas fa-print"></i> Cetak / Unduh Invoice
        </button>
    </div>

    <div class="back-link">
        <a href="/customer/dashboard">← Kembali ke Dashboard</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
