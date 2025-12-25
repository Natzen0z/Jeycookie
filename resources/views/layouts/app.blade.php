<!DOCTYPE html>
<<<<<<< Updated upstream
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jeycookie</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<!-- =======================
     Navbar (FIXED)
======================== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        # Brand / Logo
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            Jeycookie
        </a>

        # Tombol toggle (INI YANG KAMU KURANG)
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        # Menu yang bisa collapse
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">
                        Our Product
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        Cart
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>


<!-- =======================
     Content
======================== -->
<div class="container mt-4">
    @yield('content')
</div>

<!-- =======================
     Footer
======================== -->
<footer class="bg-light text-center py-3 mt-5">
    <small>© {{ date('Y') }} Jeycookie</small>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
=======
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'JeeyCookie') }} - @yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @stack('head')
</head>

<body class="bg-soft-peach">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div class="brand-badge">🍩</div>
                <span class="ms-2 brand-text">JeeyCookie</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/order') }}">Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/partnership') }}">Partnership</a></li>
                </ul>

                <a href="{{ url('/order') }}" class="btn btn-pink ms-lg-3 d-none d-lg-inline-block">Buy Now</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="py-5">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- FOOTER (simple fallback; pages can extend if needed) -->
    <footer class="footer bg-cream py-5">
        <div class="container text-center">
            <p class="mb-1">&copy; {{ date('Y') }} JeeyCookie. Freshly baked with love.</p>
            <small class="text-muted">Follow us on <i class="fa-brands fa-instagram"></i> @jeeycookie</small>
        </div>
    </footer>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
>>>>>>> Stashed changes
