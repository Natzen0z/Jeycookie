@extends('layouts.app')

@section('title', $product->name)

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        @if($product->category)
            <li class="breadcrumb-item">
                <a href="{{ route('products.category', $product->category) }}">{{ $product->category->name }}</a>
            </li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row g-4">
    <!-- Product Image -->
    <div class="col-lg-5">
        <div class="product-detail-image">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded-4 shadow">
            @else
                <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=600&h=600&fit=crop" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded-4 shadow">
            @endif
        </div>
    </div>

    <!-- Product Info -->
    <div class="col-lg-7">
        <div class="product-detail-info">
            @if($product->category)
                <a href="{{ route('products.category', $product->category) }}" 
                   class="badge bg-pink-50 text-pink text-decoration-none mb-3" style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0.5rem 1rem; font-size: 0.875rem;">
                    {{ $product->category->name }}
                </a>
            @endif

            <h1 class="fw-bold mb-2" style="font-family: 'Playfair Display', serif; font-size: 3rem; line-height: 1.1; letter-spacing: -1px;">{{ $product->name }}</h1>
            
            <!-- Rating (placeholder) -->
            <div class="mb-3" style="font-family: 'Poppins', sans-serif;">
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star-half-stroke text-warning"></i>
                <span class="text-muted ms-2">(4.5) • 50+ terjual</span>
            </div>

            <div class="price-box mb-4">
                <span class="display-6 fw-bold text-pink">{{ $product->formatted_price }}</span>
            </div>

            <!-- Stock Status -->
            <div class="mb-4">
                @if($product->stock == 0)
                    <span class="badge bg-danger fs-6">
                        <i class="fa-solid fa-times-circle me-1"></i> Stok Habis
                    </span>
                @elseif($product->isLowStock())
                    <span class="badge bg-warning fs-6">
                        <i class="fa-solid fa-exclamation-triangle me-1"></i> Sisa {{ $product->stock }} item
                    </span>
                @else
                    <span class="badge bg-success fs-6">
                        <i class="fa-solid fa-check-circle me-1"></i> Stok Tersedia
                    </span>
                @endif
            </div>

            <!-- Description -->
            @if($product->description)
                <div class="mb-4">
                    <h6 class="fw-semibold" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Deskripsi</h6>
                    <p class="text-muted" style="font-family: 'Poppins', sans-serif;">{{ $product->description }}</p>
                </div>
            @endif

            <!-- Weight if available -->
            @if($product->weight)
                <div class="mb-4">
                    <p class="text-muted" style="font-family: 'Poppins', sans-serif;">
                        Berat: {{ number_format($product->weight, 0) }} gram
                    </p>
                </div>
            @endif

            <!-- Add to Cart Form & Buy Now Button -->
            @if($product->isInStock())
                <div class="row g-3 mb-4">
                    <!-- Add to Cart -->
                    <div class="col-12">
                        <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="row g-3 align-items-end">
                                <div class="col-auto">
                                    <label for="quantity" class="form-label fw-600" style="font-family: 'Poppins', sans-serif;">Jumlah</label>
                                    <div class="input-group" style="width: 140px;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()" style="font-family: 'Poppins', sans-serif;">−</button>
                                        <input type="number" 
                                               class="form-control text-center" 
                                               id="quantity" 
                                               name="quantity" 
                                               value="1" 
                                               min="1" 
                                               max="{{ $product->stock }}"
                                               style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()" style="font-family: 'Poppins', sans-serif;">+</button>
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-pink btn-lg w-100" style="font-family: 'Poppins', sans-serif; font-weight: 600; border-width: 2px;">
                                        Keranjang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Quick Buy Button (Langsung bayar tanpa login) -->
                    <div class="col-12">
                        <button type="button" 
                                class="btn btn-pink btn-lg w-100"
                                onclick="openQuickBuyModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})"
                                style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0.875rem 1.5rem; border-radius: 2rem; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.3);">
                            Beli Sekarang (Tanpa Login)
                        </button>
                    </div>

                    <!-- Buy Now Button (Add to cart) -->
                    <div class="col-12">
                        <form action="{{ route('products.buyNow', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-lg w-100" style="font-family: 'Poppins', sans-serif; font-weight: 600; border-width: 2px;">
                                Tambah ke Keranjang & Checkout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    Produk ini sedang tidak tersedia. Silakan cek kembali nanti.
                </div>
            @endif

            <!-- Quick Info -->
            <div class="row g-3 mt-2">
                <div class="col-6">
                    <div class="d-flex align-items-center text-muted">
                        <small style="font-family: 'Poppins', sans-serif;">Pengiriman cepat</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center text-muted">
                        <small style="font-family: 'Poppins', sans-serif;">Garansi kualitas</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center text-muted">
                        <small style="font-family: 'Poppins', sans-serif;">Fresh baked daily</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center text-muted">
                        <small style="font-family: 'Poppins', sans-serif;">Packaging aman</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->isNotEmpty())
    <section class="mt-5">
        <h3 class="fw-bold mb-4">Produk Serupa</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
                <div class="col-6 col-md-3">
                    <div class="product-card h-100">
                        <a href="{{ route('products.show', $related) }}" class="text-decoration-none">
                            <div class="product-image-wrapper">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" 
                                         alt="{{ $related->name }}" 
                                         class="product-image">
                                @else
                                    <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=300&h=300&fit=crop" 
                                         alt="{{ $related->name }}" 
                                         class="product-image">
                                @endif
                            </div>
                        </a>
                        <div class="product-info">
                            <span class="product-category">{{ $related->category->name ?? '' }}</span>
                            <a href="{{ route('products.show', $related) }}" class="text-decoration-none">
                                <h6 class="product-title">{{ $related->name }}</h6>
                            </a>
                            <span class="product-price">{{ $related->formatted_price }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

@endsection

@push('scripts')
<script>
    const maxStock = {{ $product->stock }};
    
    function decreaseQty() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    }
    
    function increaseQty() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value);
        if (value < maxStock) {
            input.value = value + 1;
        }
    }
</script>
@endpush

@push('styles')
<style>
    .product-detail-image img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
    }
    
    .price-box {
        background: linear-gradient(135deg, var(--pink-50), var(--peach-50));
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        display: inline-block;
    }
    
    .text-pink {
        color: var(--pink-600);
    }
    
    .bg-pink-50 {
        background: var(--pink-50);
    }
</style>
@endpush
