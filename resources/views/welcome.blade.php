@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section dengan Carousel -->
    <section class="hero-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                @for($i = 0; $i < 5; $i++)
                <button type="button" 
                        data-bs-target="#heroCarousel" 
                        data-bs-slide-to="{{ $i }}" 
                        class="{{ $i == 0 ? 'active' : '' }}"
                        aria-current="{{ $i == 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $i + 1 }}">
                </button>
                @endfor
            </div>
            
            <!-- Slides -->
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="hero-slide slide-1"></div>
                </div>
                
                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="hero-slide slide-2"></div>
                </div>
                
                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="hero-slide slide-3"></div>
                </div>
                
                <!-- Slide 4 -->
                <div class="carousel-item">
                    <div class="hero-slide slide-4"></div>
                </div>
                
                <!-- Slide 5 -->
                <div class="carousel-item">
                    <div class="hero-slide slide-5"></div>
                </div>
            </div>
            
            <!-- Konten teks di atas carousel -->
            <div class="carousel-caption">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <h1 class="display-8 fw-bold mb-4 hero-title">
                                We create <span class="hero-highlight">high-</span>performing digital <span class="hero-highlight">designs</span> 
                            </h1>
                            <p class="lead mb-5 hero-subtitle">
                                that elevate brands and enhance conversions. Professional photo studio for all your creative needs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Controls/arrows -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Studio Showcase -->
    <section class="section-padding bg-light" id="studios">
        <div class="container text-dark">
            <div class="text-center mt-5 mb-5">
                <h2 class="fw-bold mb-3">Our Studio Spaces</h2>
                <p class="text-muted">Choose from our variety of studio setups</p>
            </div>
            <div class="row">
                @foreach($studios as $studio)
                <div class="col-md-4 mb-4">
                    <div class="card card-hover h-100">
                        <a href="/customer/studio/{{ $studio->id }}" class="text-decoration-none">
                            <img src="{{ asset($studio->gambar) }}" 
                                 class="card-img-top" 
                                 alt="{{ $studio->nama }}"
                                 style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark">{{ $studio->nama }}</h5>
                                <p class="card-text text-muted">{{ $studio->deskripsi ?? 'Studio profesional untuk kebutuhan fotografi Anda' }}</p>
                                <p class="card-text">
                                    <strong class="text-dark">Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}/jam</strong>
                                </p>
                            </div>
                        </a>
                        <div class="card-footer bg-white border-0 pb-3">
                            <!-- Tombol untuk pergi ke halaman studio spesifik -->
                            <a href="/customer/studio/{{ $studio->id }}" class="btn btn-utama w-100">
                                Book This Studio
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </section>

    <!-- Features Section - DIPINDAHKAN KE BAWAH -->
    <section class="section-padding" id="gallery">
        <!--<div class="container text-dark">
            <div class="text-center mt-5 mb-5">
                <h2 class="fw-bold mb-3">Our Services</h2>
                <p class="text-muted">Professional studio with state-of-the-art equipment</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="text-center p-4">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-camera fa-2x text-white"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">Professional Equipment</h4>
                        <p class="text-muted">High-end cameras, lighting, and backdrops for perfect shots.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="text-center p-4">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-clock fa-2x text-white"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">Flexible Hours</h4>
                        <p class="text-muted">Book anytime with our 24/7 online booking system.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="text-center p-4">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-award fa-2x text-white"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">Expert Team</h4>
                        <p class="text-muted">Professional photographers and assistants available.</p>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Gallery Section -->
<div class="text-center mt-5 mb-4">
    <h2 class="fw-bold mb-3 text-dark">Gallery</h2>
    <p class="text-muted">Our portfolio of photography work</p>
</div>

<div class="container-fluid px-2 px-md-4">
    <!-- Masonry Grid dengan Bootstrap Columns -->
    <div class="row gallery-masonry">
        <!-- Column 1 -->
        <div class="col-md-3 col-6">
            <div class="mb-3">
                <img src="{{ asset('/images/studio/potrait1.jpg') }}" 
                     alt="Portrait 1" 
                     class="img-fluid rounded w-100 mb-3">
                <img src="{{ asset('/images/studio/photo1.jpg') }}" 
                     alt="Product 1" 
                     class="img-fluid rounded w-100 mb-3">
                <img src="{{ asset('/images/studio/1769347123_product-studio.jpg') }}" 
                     alt="Product Studio" 
                     class="img-fluid rounded w-100">
            </div>
        </div>
        
        <!-- Column 2 -->
        <div class="col-md-3 col-6">
            <div class="mb-3">
                <img src="{{ asset('/images/studio/potrait2.jpg') }}" 
                     alt="Portrait 2" 
                     class="img-fluid rounded w-100 mb-3">
                <img src="{{ asset('/images/studio/1769347060_potrait-studio.jpg') }}" 
                     alt="Portrait Studio" 
                     class="img-fluid rounded w-100">
            </div>
        </div>
        
        <!-- Column 3 -->
        <div class="col-md-3 col-6">
            <div class="mb-3">
                <img src="{{ asset('/images/studio/photo2.jpg') }}" 
                     alt="Product 2" 
                     class="img-fluid rounded w-100 mb-3">
                <img src="https://i.pinimg.com/736x/ab/d8/ed/abd8ed294aad391f2b11b5825b61c624.jpg" 
                     alt="Studio 3" 
                     class="img-fluid rounded w-100 mb-3">
                
            </div>
        </div>
        
        <!-- Column 4 -->
        <div class="col-md-3 col-6">
            <div class="mb-3">
                <img src="https://i.pinimg.com/1200x/9a/e2/0e/9ae20e3ca0cee3884ecbaea8fe5b367f.jpg" 
                     alt="Example 1" 
                     class="img-fluid rounded w-100 mb-3">
                <img src="https://i.pinimg.com/736x/8c/e4/3d/8ce43d3ecc782b1d9cacc19ec9b80291.jpg" 
                     alt="Example 2" 
                     class="img-fluid rounded w-100">
            </div>
        </div>
    </div>
</div>
    </section>
@endsection