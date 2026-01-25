<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Studio - Admin</title>
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
            <h2 class="studio-page-title">
                <i class="fas fa-photo-video me-2"></i>Manajemen Studio
            </h2>
            <a href="/admin/studio/tambah" class="btn studio-btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Tambah Studio
            </a>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success studio-alert alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger studio-alert alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($studios->count() > 0)
        <!-- Search Box -->
        <div class="card studio-form-card mb-3">
            <div class="card-body">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="searchStudio" class="form-control" placeholder="Cari studio berdasarkan nama, harga, atau kapasitas...">
                </div>
                <small class="text-muted mt-2 d-block">Ketik untuk mencari data secara real-time</small>
            </div>
        </div>

        <div class="card studio-form-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover studio-table" id="studioTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Studio</th>
                                <th>Harga/Jam</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="studioTableBody">
                            @foreach($studios as $studio)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($studio->gambar)
                                            <img src="{{ asset($studio->gambar) }}" alt="{{ $studio->nama }}" class="studio-img-thumbnail">
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-image"></i> No Image
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $studio->nama }}</td>
                                    <td>Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</td>
                                    <td>{{ $studio->kapasitas }} orang</td>
                                    <td>
                                        @if($studio->status == 'tersedia')
                                            <span class="studio-badge-tersedia">Tersedia</span>
                                        @else
                                            <span class="studio-badge-tidak-tersedia">Tidak Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/admin/studio/edit/{{ $studio->id }}" class="btn btn-sm studio-btn-warning">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <a href="/admin/studio/hapus/{{ $studio->id }}" 
                                           class="btn btn-sm studio-btn-warning"
                                           onclick="return confirm('Yakin hapus studio {{ $studio->nama }}?')">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info studio-alert">
            <i class="fas fa-info-circle me-2"></i> Belum ada data studio. 
            <a href="/admin/studio/tambah" class="alert-link">Tambah studio pertama</a>
        </div>
        @endif

        <div class="mt-3">
            <a href="/admin/dashboard" class="btn studio-btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Store all table rows
            var studioRows = $('#studioTableBody').html();

            $('#searchStudio').on('keyup', function() {
                var searchValue = $(this).val().toLowerCase();

                if (searchValue === '') {
                    $('#studioTableBody').html(studioRows);
                    return;
                }

                var filteredRows = '';
                var rowCount = 0;

                $('#studioTableBody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.includes(searchValue)) {
                        filteredRows += $(this).prop('outerHTML');
                        rowCount++;
                    }
                });

                if (rowCount > 0) {
                    $('#studioTableBody').html(filteredRows);
                } else {
                    $('#studioTableBody').html('<tr><td colspan="7" class="text-center text-muted py-3"><i class="fas fa-search me-2"></i>Tidak ada data yang sesuai</td></tr>');
                }
            });
        });
    </script>
</body>
</html>