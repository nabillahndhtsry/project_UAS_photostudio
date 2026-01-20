<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Customer - Admin</title>
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
                <i class="fas fa-users me-2"></i>Data Customer
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

        <!-- Filter Form -->
        <div class="card payment-table-card mb-4">
            <div class="card-body">
                <form action="/admin/customer/filter" method="GET" class="row g-3">
                    
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari (Nama/Email/Telepon)</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Cari customer...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn payment-btn-info w-100">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                    </div>
                </form>
                <div class="mt-2">
                    <a href="/admin/customer" class="btn studio-btn-secondary btn-sm">
                        <i class="fas fa-redo me-1"></i> Reset
                    </a>
                </div>
            </div>
        </div>

        @if($customers->count() > 0)
        <div class="card payment-table-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover payment-table">
                        <thead>
                            <tr>
                                <th class="payment-table-header">#</th>
                                <th class="payment-table-header">Nama</th>
                                <th class="payment-table-header">Email</th>
                                <th class="payment-table-header">Telepon</th>
                                <th class="payment-table-header">Alamat</th>
                                <th class="payment-table-header">Tanggal Daftar</th>
                                <!-- KOLOM AKSI DIHAPUS -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr class="payment-table-row">
                                    <td class="payment-table-cell">{{ $loop->iteration }}</td>
                                    <td class="payment-table-cell">
                                        <strong class="text-dark">{{ $customer->name }}</strong>
                                    </td>
                                    <td class="payment-table-cell">{{ $customer->email }}</td>
                                    <td class="payment-table-cell">{{ $customer->phone ?? '-' }}</td>
                                    <td class="payment-table-cell">{{ Str::limit($customer->address, 30) ?? '-' }}</td>
                                    <td class="payment-table-cell">{{ date('d/m/Y', strtotime($customer->created_at)) }}</td>
                                    <!-- TOMBOL AKSI DIHAPUS -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning payment-alert">
            <i class="fas fa-info-circle me-2"></i> Belum ada data customer.
        </div>
        @endif

        <div class="mt-3">
            <a href="/admin/dashboard" class="btn studio-btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set default tanggal (30 hari terakhir)
        const today = new Date().toISOString().split('T')[0];
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
        const thirtyDaysAgoStr = thirtyDaysAgo.toISOString().split('T')[0];
        
        document.getElementById('start_date').value = thirtyDaysAgoStr;
        document.getElementById('end_date').value = today;
    </script>
</body>
</html>