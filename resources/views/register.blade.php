<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Photo Studio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold" style="color: var(--dark);">
                                <i class="fas fa-camera me-2"></i>PHOTOSTUDIOVA
                            </h2>
                            <p class="text-muted">Buat akun baru untuk mulai booking</p>
                        </div>

                        <!-- Tampilkan pesan error -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/register') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" 
                                           value="{{ old('name') }}"
                                           required placeholder="Masukkan nama lengkap">
                                </div>
                                @error('name')
                                    <div class="text-danger error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" 
                                           value="{{ old('email') }}"
                                           required placeholder="contoh: john@example.com">
                                </div>
                                @error('email')
                                    <div class="text-danger error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" 
                                               value="{{ old('phone') }}"
                                               placeholder="contoh: 081234567890">
                                    </div>
                                    @error('phone')
                                        <div class="text-danger error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                               id="address" name="address" 
                                               value="{{ old('address') }}"
                                               placeholder="Masukkan alamat">
                                    </div>
                                    @error('address')
                                        <div class="text-danger error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" 
                                               required placeholder="Minimal 6 karakter">
                                    </div>
                                    @error('password')
                                        <div class="text-danger error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" 
                                               required placeholder="Ulangi password">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya setuju dengan <a href="#" class="text-decoration-none">syarat dan ketentuan</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-login w-100 mb-3">
                                <i></i>Daftar Sekarang
                            </button>
                            
                            <div class="text-center login-link">
                                <p class="mb-0">Sudah punya akun? 
                                    <a href="{{ url('/login') }}" class="text-decoration-none fw-bold">Login di sini</a>
                                </p>
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="/" class="text-decoration-none"><i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validasi password match
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                return false;
            }
        });
    </script>
</body>
</html>