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

        @if($customers->count() > 0)
        <!-- Search Box -->
        <div class="card payment-table-card mb-3">
            <div class="card-body">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="searchCustomer" class="form-control" placeholder="Cari customer berdasarkan nama, email, atau telepon...">
                </div>
                <small class="text-muted mt-2 d-block">Ketik untuk mencari data secara real-time</small>
            </div>
        </div>

        <div class="card payment-table-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover payment-table" id="customerTable">
                        <thead>
                            <tr>
                                <th class="payment-table-header">No</th>
                                <th class="payment-table-header">Nama</th>
                                <th class="payment-table-header">Email</th>
                                <th class="payment-table-header">Telepon</th>
                                <th class="payment-table-header">Alamat</th>
                                <th class="payment-table-header">Tanggal Daftar</th>
                                <!-- KOLOM AKSI DIHAPUS -->
                            </tr>
                        </thead>
                        <tbody id="customerTableBody">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Store all table rows
            var customerRows = $('#customerTableBody').html();

            $('#searchCustomer').on('keyup', function() {
                var searchValue = $(this).val().toLowerCase();

                if (searchValue === '') {
                    $('#customerTableBody').html(customerRows);
                    return;
                }

                var filteredRows = '';
                var rowCount = 0;

                $('#customerTableBody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.includes(searchValue)) {
                        filteredRows += $(this).prop('outerHTML');
                        rowCount++;
                    }
                });

                if (rowCount > 0) {
                    $('#customerTableBody').html(filteredRows);
                } else {
                    $('#customerTableBody').html('<tr><td colspan="6" class="text-center text-muted py-3"><i class="fas fa-search me-2"></i>Tidak ada data yang sesuai</td></tr>');
                }
            });
        });

        // Set default tanggal (30 hari terakhir)
        const today = new Date().toISOString().split('T')[0];
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
        const thirtyDaysAgoStr = thirtyDaysAgo.toISOString().split('T')[0];
        
        const startDateElement = document.getElementById('start_date');
        const endDateElement = document.getElementById('end_date');
        
        if (startDateElement) startDateElement.value = thirtyDaysAgoStr;
        if (endDateElement) endDateElement.value = today;
    </script>
</body>
</html>