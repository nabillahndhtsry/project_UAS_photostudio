<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Studio - Admin</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.google.com/share?selection.family=Allerta|Andika:ital,wght@0,400;0,700;1,400;1,700|Lexend:wght@100..900|Monsieur+La+Doulaise|Nanum+Myeongjo|Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800" rel="stylesheet">
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card studio-form-card">
                    <div class="card-header studio-form-header">
                        <h4 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Studio Baru
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="/admin/studio/tambah" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label studio-form-label">Nama Studio *</label>
                                <input type="text" class="form-control studio-form-control" id="nama" name="nama" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label studio-form-label">Deskripsi</label>
                                <textarea class="form-control studio-form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="harga_per_jam" class="form-label studio-form-label">Harga per Jam (Rp) *</label>
                                    <input type="number" class="form-control studio-form-control" id="harga_per_jam" name="harga_per_jam" min="0" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kapasitas" class="form-label studio-form-label">Kapasitas (orang) *</label>
                                    <input type="number" class="form-control studio-form-control" id="kapasitas" name="kapasitas" min="1" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fasilitas" class="form-label studio-form-label">Fasilitas</label>
                                <textarea class="form-control studio-form-control" id="fasilitas" name="fasilitas" rows="2" placeholder="Contoh: AC, Lighting, Backdrop"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label studio-form-label">Gambar Studio</label>
                                <input type="file" class="form-control studio-form-control" id="gambar" name="gambar" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG (max: 2MB)</small>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label studio-form-label">Status *</label>
                                <select class="form-select studio-form-control" id="status" name="status" required>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="tidak tersedia">Tidak Tersedia</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="/admin/studio" class="btn studio-btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn studio-btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Studio
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>