
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Certificate Generator')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> 
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        footer {
            background-color: #2D3E50; 
        }
        @media (max-width: 768px) {
            footer {
                background-color: #C0C8CA; 
            }
            .footer-mobile a,
            .footer-mobile p {
                color: #C0C8CA;
            }
            .footer-mobile .bi {
                color: #3E6697; 
            }
        }
    </style>
    
</head>
<body  class="@yield('body-class', '')">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg  navbar-light" style="background-color: #2D3E50; padding: 1.5rem 0;">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/Logo.svg') }}" alt="CertGen Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#verify">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('faq') }}">FAQ</a></li>
                </ul>
                <div class="d-flex gap-2">
                @auth
                    @if (auth()->user()->role === 'super-admin')
                        <a class="btn" style="background-color: #C0C8CA" href="{{ route('superadmin') }}" role="button">Dashboard</a>
                    @elseif (auth()->user()->role === 'admin')
                        <a class="btn" style="background-color: #C0C8CA" href="{{ route('admin.home') }}" role="button">Dashboard</a>
                    @endif
                @else
                    <!-- Jika belum login -->
                    <a class="btn" style="background-color: #C0C8CA" href="{{ route('login') }}" role="button">Login</a>
                @endauth
            </div>

            </div>
            </div>
        </div>
    </nav>
    
    <!-- Dynamic Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 text-light">
        <div class="container">
            <!-- Footer Desktop -->
            <div class="footer-desktop d-none d-md-block">
                <p class="mb-2">
                    Copyright &copy; 2024 Certificate Generator | All Rights Reserved
                </p>
                <p class="mb-0">
                    <a href="/terms" class="text-white text-decoration-underline">Terms and Conditions</a> | 
                    <a href="/privacy" class="text-white text-decoration-underline">Privacy Policy</a>
                </p>
            </div>
    
            <!-- Footer Mobile -->
            <div class="footer-mobile d-block d-md-none">
                <p class="mb-1 fw-bold text-dark">Copyright &copy; 2025 Certificate Generator</p>
                <p class="mb-1 text-dark">
                    Terms and Conditions | All Rights Reserved | Privacy Policy
                </p>
                
                <div class="d-flex justify-content-center gap-4 mt-3">
                    <a href="/" class="text-decoration-none text-dark fw-bold">Home</a>
                    <a href="#" class="text-decoration-none text-dark fw-bold">Feature</a>
                    <a href="#verify" class="text-decoration-none text-dark fw-bold">Works</a>
                    <a href="#testimonials" class="text-decoration-none text-dark fw-bold">Testimonial</a>
                    <a href="{{ route('faq') }}" class="text-decoration-none text-dark fw-bold">FAQ</a>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-2">
                    <a href="#" class="text-dark fs-4">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-dark fs-4">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://www.instagram.com/certificategenerator/profilecard/?igsh=OHRmeWVpeDJsMDF4" class="text-dark fs-4">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-dark fs-4">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" class="text-dark fs-4">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>                
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 