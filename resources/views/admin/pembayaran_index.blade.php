<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran - Admin</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="body">
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-navbar">
        <div class="container">
            <a class="navbar-brand dashboard-brand" href="/admin/dashboard">
                <i class="fas fa-camera me-2"></i>PHOTOSTUDIOVA <span class="dashboard-subtitle">Admin Panel</span>
            </a>
            <div class="navbar-text text-light">
                Login sebagai: <strong>{{ Session::get('name') }}</strong> | 
                
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn logout-btn">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="payment-page-title">
                <i class="fas fa-credit-card me-2"></i>Data Pembayaran
            </h2>
            
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success payment-alert alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger payment-alert alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(Session::has('info'))
            <div class="alert alert-info payment-alert alert-dismissible fade show">
                <i class="fas fa-info-circle me-2"></i>{{ Session::get('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(isset($status))
            <div class="alert payment-status-alert">
                <i class="fas fa-filter me-2"></i>Menampilkan pembayaran dengan status: 
                <strong class="text-dark">{{ $status == 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}</strong>
            </div>
        @endif

        @if($pembayaran->count() > 0)
        <div class="card payment-table-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover payment-table">
                        <thead>
                            <tr>
                                <th class="payment-table-header">#</th>
                                <th class="payment-table-header">Customer</th>
                                <th class="payment-table-header">Studio</th>
                                <th class="payment-table-header">Total Bayar</th>
                                <th class="payment-table-header">Metode</th>
                                <th class="payment-table-header">Status</th>
                                <th class="payment-table-header">Tanggal Bayar</th>
                                <th class="payment-table-header">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembayaran as $item)
                                <tr class="payment-table-row">
                                    <td class="payment-table-cell">{{ $loop->iteration }}</td>
                                    <td class="payment-table-cell">
                                        <strong class="text-dark">{{ $item->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $item->email }}</small><br>
                                        <small class="text-dark">{{ $item->phone }}</small>
                                    </td>
                                    <td class="payment-table-cell text-dark">{{ $item->studio_name }}</td>
                                    <td class="payment-table-cell">
                                        <strong class="text-dark">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</strong>
                                    </td>
                                    <td class="payment-table-cell">
                                        @if($item->metode_bayar == 'transfer')
                                            <span class="payment-badge-method-info">Transfer</span>
                                        @elseif($item->metode_bayar == 'tunai')
                                            <span class="payment-badge-method-success">Tunai</span>
                                        @else
                                            <span class="payment-badge-method-primary">E-Wallet</span>
                                        @endif
                                    </td>
                                    <td class="payment-table-cell">
                                        @if($item->status_bayar == 'lunas')
                                            <span class="payment-badge-status-success">Lunas</span>
                                        @else
                                            <span class="payment-badge-status-warning">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td class="payment-table-cell">
                                        @if($item->tanggal_bayar)
                                            <span class="text-dark">{{ date('d/m/Y', strtotime($item->tanggal_bayar)) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="payment-table-cell">
                                        <a href="/admin/pembayaran/{{ $item->id }}" class="btn payment-btn-info" title="Detail">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        
                                        @if($item->status_bayar == 'belum_lunas')
                                            <form action="{{ route('admin.pembayaran.confirm', $item->id) }}" 
                                                method="POST" 
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn payment-btn-success"
                                                        onclick="return confirm('Konfirmasi pembayaran ini sebagai LUNAS?')"
                                                        title="Konfirmasi Lunas">
                                                    <i class="fas fa-check-circle me-1"></i>Konfirmasi
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $pembayaran->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning payment-alert">
            <i class="fas fa-info-circle me-2"></i> Belum ada data pembayaran.
        </div>
        @endif

        <div class="mt-3">
            <a href="/admin/dashboard" class="btn studio-btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>