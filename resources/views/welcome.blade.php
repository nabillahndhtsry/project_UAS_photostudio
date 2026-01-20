@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mx-auto text-center">
                    <h1 class="display-8 fw-bold mb-4" style="color: var(--light);">
                        We create <span style="color: var(--dark);">high-</span>performing digital <span style="color: var(--dark);">designs</span> 
                    </h1>
                    <p class="lead mb-5" style="font-size: 1.25rem; color: var(--light);">
                        that elevate brands and enhance conversions. Professional photo studio for all your creative needs.
                    </p>
                    ]
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section-padding bg-light" id="services">
        <div class="container text-dark">
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
        </div>
    </section>

    <!-- Studio Showcase -->
    <section class="section-padding" id="studios">
        <div class="container text-dark">
            <div class="text-center mt-5 mb-5">
                <h2 class="fw-bold mb-3">Our Studio Spaces</h2>
                <p class="text-muted">Choose from our variety of studio setups</p>
            </div>
            <div class="row">
                @php
                    $studios = [
                        ['name' => 'Portrait Studio', 'price' => 150000, 'desc' => 'Perfect for portrait photography', 'image' => 'https://i.pinimg.com/736x/eb/b8/fb/ebb8fbc05320654019106742e29e536c.jpg'],
                        ['name' => 'Product Studio', 'price' => 200000, 'desc' => 'Designed for product photography', 'image' => 'https://plus.unsplash.com/premium_photo-1726869694722-66df5f9621b8?q=80&w=1079&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
                        ['name' => 'Studio', 'price' => 250000, 'desc' => 'Ideal for private photoshoot', 'image' => 'https://i.pinimg.com/1200x/9f/e6/c8/9fe6c8ea90cd8e4819efe2fb982b3d64.jpg'],
                    ];
                @endphp
                
                @foreach($studios as $studio)
                <div class="col-md-4 mb-4 ">
                    <div class="card card-hover">
                        <img src="{{ $studio['image'] }}" 
                             class="card-img-top" 
                             alt="{{ $studio['name'] }}"
                             style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $studio['name'] }}</h5>
                            <p class="card-text text-muted">{{ $studio['desc'] }}</p>
                           
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                
            </div>
        </div>
    </section>

    <!-- CTA Section 
    <section class="section-padding" style="background: var(--dark); color: white;">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Ready to Create Amazing Content?</h2>
            
        </div>
    </section>-->
@endsection