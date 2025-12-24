<!DOCTYPE html>
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
