@extends('layouts.app')
<<<<<<< Updated upstream

@section('content')

<!-- Hero -->
<div class="text-center p-5 bg-light rounded">
    <h1 class="fw-bold">Jeycookie 🍪</h1>
    <p class="text-muted">Fresh homemade cookies for your sweet moment</p>
</div>

<!-- Kategori -->
<h3 class="mt-5 mb-3">Kategori</h3>

<div class="row">
    @foreach ($categories as $category)
        <div class="col-md-4">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $category }}</h5>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
=======
@section('title','Home')

@section('content')

<!-- HERO -->
<section class="hero-card mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6 hero-left">
            <h1 class="display-5 fw-bold text-pink-600">Fresh Donuts & Cookies Everyday 🍩</h1>
            <p class="lead text-muted mt-3">Nikmati donut lembut dan cookies renyah dibuat fresh setiap hari menggunakan bahan premium. Rasakan rasa yang membuat senyum terus merekah.</p>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ url('/order') }}" class="btn btn-pink btn-lg">Order Now</a>
                <a href="#hot-deals" class="btn btn-outline-secondary btn-lg">Hot Deals</a>
            </div>

            <!-- small badges -->
            <div class="d-flex gap-3 mt-4">
                <div class="d-flex align-items-center">
                    <div class="me-2 p-2 rounded-circle" style="background:#fff3f8"><i class="fa-solid fa-bread-slice text-pink-500"></i></div>
                    <div><small class="text-muted">Fresh Daily</small></div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="me-2 p-2 rounded-circle" style="background:#fff8ea"><i class="fa-solid fa-seedling text-warning"></i></div>
                    <div><small class="text-muted">Natural Ingredients</small></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 text-center">
            <img src="https://i.ibb.co/gWP7P8w/donut-pink.png" alt="donut" class="product-img mt-3">
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm text-center">
                <h5 class="fw-bold text-pink-600">Freshly Baked</h5>
                <p class="text-muted small">Setiap hari dipanggang di toko kami.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm text-center">
                <h5 class="fw-bold text-pink-600">Premium Ingredients</h5>
                <p class="text-muted small">Tanpa pengawet, hanya bahan terbaik.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 bg-white rounded-4 shadow-sm text-center">
                <h5 class="fw-bold text-pink-600">Fast Delivery</h5>
                <p class="text-muted small">Pesanan cepat sampai.</p>
            </div>
        </div>
    </div>
</section>

<!-- HOT DEALS (product grid) -->
<section id="hot-deals" class="mb-5">
    <h3 class="fw-bold mb-4 text-pink-600">Hot Deals</h3>

    <div class="row g-4">
        @php
        // contoh produk statis — nanti bisa di loop dari DB
        $products = [
        ['title'=>'Pink Donut','price'=>'15.000','img'=>'https://i.ibb.co/gWP7P8w/donut-pink.png'],
        ['title'=>'Chocolate Donut','price'=>'17.000','img'=>'https://i.ibb.co/XpkvLDY/donut-choco.png'],
        ['title'=>'Chocolate Cookies','price'=>'12.000','img'=>'https://i.ibb.co/d4tHNgT/cookie-choco.png'],
        ['title'=>'Sprinkle Donut','price'=>'16.000','img'=>'https://i.ibb.co/3y5Yp2Q/donut-sprinkle.png']
        ];
        @endphp

        @foreach($products as $p)
        <div class="col-sm-6 col-lg-3">
            <div class="product-card text-center h-100 d-flex flex-column align-items-center">
                <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" class="product-img mb-3">
                <h6 class="fw-bold text-pink-600 mb-1">{{ $p['title'] }}</h6>
                <p class="text-muted mb-3">Rp {{ $p['price'] }}</p>
                <a href="{{ url('/order') }}" class="btn btn-pink mt-auto">Add to Cart</a>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- QUALITY COMMITMENT -->
<section class="mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <img src="https://i.ibb.co/QkqZ4Bk/donut-box.png" alt="box" class="img-fluid rounded-3 shadow-sm">
        </div>
        <div class="col-lg-6">
            <h3 class="fw-bold text-pink-600">Our Quality Commitment</h3>
            <ul class="mt-3">
                <li class="text-muted mb-2">✔ No preservatives — hanya bahan alami.</li>
                <li class="text-muted mb-2">✔ Baked fresh every morning.</li>
                <li class="text-muted mb-2">✔ Hygienic & quality-controlled production.</li>
            </ul>
        </div>
    </div>
</section>

<!-- OFFER BANNER -->
<section class="offer-banner mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="fw-bold">Get 35% Off For First Order</h4>
            <p class="text-muted">Gunakan kode <span class="fw-semibold">SWEET35</span> di checkout — hanya untuk pelanggan baru!</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ url('/order') }}" class="btn btn-pink btn-lg">Claim Offer</a>
        </div>
    </div>
</section>

<!-- TESTIMONIALS (carousel) -->
<section class="mb-5">
    <h4 class="fw-bold text-pink-600 mb-4">What customers say</h4>

    <div id="testiCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="testimonial-card d-flex gap-3 align-items-center">
                    <img src="https://i.pravatar.cc/80?img=3" class="rounded-circle" alt="avatar">
                    <div>
                        <p class="mb-1">"Donut nya lembut, toppingnya pas. Enak banget!"</p>
                        <small class="text-muted">— Dewi, Jakarta</small>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="testimonial-card d-flex gap-3 align-items-center">
                    <img src="https://i.pravatar.cc/80?img=5" class="rounded-circle" alt="avatar2">
                    <div>
                        <p class="mb-1">"Cepat sampai dan pack nya rapi. Recommended!"</p>
                        <small class="text-muted">— Andi, Bandung</small>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="testimonial-card d-flex gap-3 align-items-center">
                    <img src="https://i.pravatar.cc/80?img=7" class="rounded-circle" alt="avatar3">
                    <div>
                        <p class="mb-1">"Worth the price. Rasanya otentik dan nggak eneg."</p>
                        <small class="text-muted">— Sinta, Surabaya</small>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#testiCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testiCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h5 class="fw-bold text-pink-600">Join our sweet community</h5>
            <p class="text-muted">Dapatkan promo & resep eksklusif langsung ke inbox.</p>
        </div>
        <div class="col-md-4">
            <form class="d-flex">
                <input class="form-control input-news me-2" placeholder="Masukkan email kamu">
                <button class="btn btn-pink">Subscribe</button>
            </form>
        </div>
    </div>
</section>

@endsection
>>>>>>> Stashed changes
