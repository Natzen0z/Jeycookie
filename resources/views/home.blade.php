@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- HERO SECTION -->
<section class="mb-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Hero Text -->
        <div>
            <h1 class="text-5xl md:text-6xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">
                Enjoy Every Bite<br>Quality Bakes, Curated for You
            </h1>
            <p class="text-gray-600 text-lg mb-6">
                Bakery offering fresh breads, donuts, cookies, and premium snack box for any occasion.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mb-8">
                <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition text-center">
                    Shop Now
                </a>
                <a href="#categories" class="border-2 border-pink-500 text-pink-600 px-8 py-3 rounded-lg font-semibold hover:bg-pink-50 transition text-center">
                    Browse Categories
                </a>
            </div>

            <!-- Feature Badges -->
            <div class="flex flex-wrap gap-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-star text-pink-500 text-lg"></i>
                    <span class="text-gray-700">Fresh Daily</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-leaf text-green-500 text-lg"></i>
                    <span class="text-gray-700">Natural Ingredients</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-rocket text-blue-500 text-lg"></i>
                    <span class="text-gray-700">Fast Delivery</span>
                </div>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="relative">
            <img src="https://res.cloudinary.com/dde7nabsx/image/upload/v1767420334/IMG_9251_pbyge9_xjwxgx.jpg"
                 alt="Delicious Cookies" class="rounded-lg shadow-xl w-full h-auto">
            <div class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg font-bold">
                20% OFF <br><span class="text-sm font-normal">First Order</span>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="mb-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-4xl mb-4">🎂</div>
            <h5 class="font-bold text-lg mb-2">Freshly Baked</h5>
            <p class="text-gray-600 text-sm">Setiap produk dipanggang segar dari oven setiap hari.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-4xl mb-4">⭐</div>
            <h5 class="font-bold text-lg mb-2">Premium Quality</h5>
            <p class="text-gray-600 text-sm">Hanya menggunakan bahan-bahan berkualitas tinggi.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
            <div class="text-4xl mb-4">🚚</div>
            <h5 class="font-bold text-lg mb-2">Fast Delivery</h5>
            <p class="text-gray-600 text-sm">Pesanan dikirim cepat dan dikemas dengan aman.</p>
        </div>
    </div>
</section>

<!-- CATEGORIES SECTION -->
<section id="categories" class="mb-12">
    <div class="text-center mb-8">
        <h2 class="text-4xl font-bold mb-2">Browse by Category</h2>
        <p class="text-gray-600">Temukan produk favorit berdasarkan kategori</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($categories as $category)
        <a href="{{ route('products.category', $category->slug) }}" class="group">
            <div class="bg-white rounded-lg p-4 text-center hover:shadow-lg transition cursor-pointer">
                <div class="text-5xl mb-3">
                    @switch($category->name)
                        @case('Cookies') 🍪 @break
                        @case('Donut') 🍩 @break
                        @case('Bread') 🍞 @break
                        @case('Cake') 🎂 @break
                        @default 🥐
                    @endswitch
                </div>
                <h5 class="font-bold text-gray-800 group-hover:text-pink-600 transition">{{ $category->name }}</h5>
                <p class="text-sm text-gray-500">{{ $category->products_count ?? 0 }} produk</p>
            </div>
        </a>
        @empty
        <p class="col-span-full text-center text-gray-500">Tidak ada kategori</p>
        @endforelse
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="mb-12">
    <div class="text-center mb-8">
        <h2 class="text-4xl font-bold mb-2">Featured Products</h2>
        <p class="text-gray-600">Produk pilihan terbaru kami</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition group">
            <!-- Product Image -->
            <div class="relative overflow-hidden h-48 bg-gray-100">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition">
                @if(!$product->is_active || $product->stock <= 0)
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <span class="text-white font-bold">Out of Stock</span>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h5 class="font-bold text-gray-800">{{ $product->name }}</h5>
                        <p class="text-sm text-gray-500">{{ $product->category->name ?? 'No Category' }}</p>
                    </div>
                    @if($product->stock <= 5)
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded">Limited</span>
                    @endif
                </div>

                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>

                <div class="flex justify-between items-center mb-4">
                    <span class="text-2xl font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-sm text-gray-500">Stock: {{ $product->stock }}</span>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('products.show', $product->slug) }}" class="flex-1 bg-gray-100 text-gray-800 py-2 rounded-lg text-center font-semibold hover:bg-gray-200 transition">
                        View
                    </a>
                    @if($product->is_active && $product->stock > 0)
                        <button onclick="openQuickBuyModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }})" 
                                class="flex-1 bg-gradient-to-r from-pink-500 to-pink-600 text-white py-2 rounded-lg font-semibold hover:shadow-lg transition">
                            Quick Buy
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="col-span-full text-center text-gray-500 py-8">Tidak ada produk tersedia</p>
        @endforelse
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('products.index') }}" class="inline-block border-2 border-pink-500 text-pink-600 px-8 py-3 rounded-lg font-semibold hover:bg-pink-50 transition">
            View All Products
        </a>
    </div>
</section>

@endsection
                    @case('Donuts')
                    🍩
                    @break
                    @case('Cakes')
                    🎂
                    @break
                    @case('Brownies')
                    🍫
                    @break
                    @case('Pastries')
                    🥐
                    @break
                    @default
                    🧁
                    @endswitch
                </div>
                <h6 class="mt-2 mb-0 fw-semibold">{{ $category->name }}</h6>
                <small class="text-muted">{{ $category->products_count ?? 0 }} products</small>
            </a>
        </div>
        @empty
        <div class="col-6 col-md-3">
            <div class="category-card">
                <div class="category-icon">🍪</div>
                <h6 class="mt-2 mb-0 fw-semibold">Traditional Cake</h6>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="category-card">
                <div class="category-icon">🍩</div>
                <h6 class="mt-2 mb-0 fw-semibold">Donuts</h6>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="category-card">
                <div class="category-icon">🎂</div>
                <h6 class="mt-2 mb-0 fw-semibold">Sweet</h6>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="category-card">
                <div class="category-icon">🥐</div>
                <h6 class="mt-2 mb-0 fw-semibold">salty</h6>
            </div>
        </div>
        @endforelse
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<section id="featured" class="mb-5">
    <div class="section-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Featured Products</h2>
            <p class="text-muted mb-0">Produk terlaris dan paling disukai</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-pink">
            View All <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-4">
        @forelse($featuredProducts as $product)
        <div class="col-6 col-lg-3">
            <div class="product-card h-100">
                <div class="product-image-wrapper">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                    <img src="https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=300&h=300&fit=crop"
                        alt="{{ $product->name }}" class="product-image">
                    @endif
                    @if($product->stock < 5 && $product->stock > 0)
                        <span class="product-badge bg-warning">Low Stock</span>
                        @elseif($product->stock == 0)
                        <span class="product-badge bg-danger">Sold Out</span>
                        @endif
                </div>
                <div class="product-info">
                    <span class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                    <h6 class="product-title">{{ $product->name }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm btn-pink">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        @php
        $sampleProducts = [
        ['title' => 'Chocolate Chip Cookie', 'price' => 15000, 'img' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=300&h=300&fit=crop'],
        ['title' => 'Pink Glazed Donut', 'price' => 18000, 'img' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=300&h=300&fit=crop'],
        ['title' => 'Red Velvet Cake', 'price' => 85000, 'img' => 'https://images.unsplash.com/photo-1586788680434-30d324b2d46f?w=300&h=300&fit=crop'],
        ['title' => 'Fudge Brownies', 'price' => 25000, 'img' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=300&h=300&fit=crop'],
        ];
        @endphp
        @foreach($sampleProducts as $p)
        <div class="col-6 col-lg-3">
            <div class="product-card h-100">
                <div class="product-image-wrapper">
                    <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" class="product-image">
                </div>
                <div class="product-info">
                    <span class="product-category">Cookies</span>
                    <h6 class="product-title">{{ $p['title'] }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="product-price">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
                        <button class="btn btn-sm btn-pink">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endforelse
    </div>
</section>

<!-- PROMO BANNER -->
<section class="promo-banner mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="fw-bold mb-2">🎉 First Order Discount!</h3>
            <p class="mb-0 text-muted">Dapatkan diskon 20% untuk pembelian pertama kamu. Gunakan kode <span class="promo-code">SWEET20</span> saat checkout!</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('products.index') }}" class="btn btn-pink btn-lg">
                <i class="fa-solid fa-tag me-2"></i> Shop Now
            </a>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="mb-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-6">
            <img src="https://res.cloudinary.com/dppmxyqt4/image/upload/v1767450060/WhatsApp_Image_2026-01-03_at_19.25.39_mrstke.jpg"
                alt="Our Kitchen" class="img-fluid rounded-4 shadow">
        </div>
        <div class="col-lg-6">
            <h2 class="fw-bold mb-4">Why Choose Jeycookie?</h2>
            <div class="why-item mb-3">
                <div class="why-icon"><i class="fa-solid fa-check"></i></div>
                <div>
                    <h6 class="fw-semibold mb-1">No Preservatives</h6>
                    <p class="text-muted small mb-0">100% bahan alami tanpa pengawet buatan.</p>
                </div>
            </div>
            <div class="why-item mb-3">
                <div class="why-icon"><i class="fa-solid fa-check"></i></div>
                <div>
                    <h6 class="fw-semibold mb-1">Baked Fresh Every Morning</h6>
                    <p class="text-muted small mb-0">Produk dibuat segar setiap hari.</p>
                </div>
            </div>
            <div class="why-item mb-3">
                <div class="why-icon"><i class="fa-solid fa-check"></i></div>
                <div>
                    <h6 class="fw-semibold mb-1">Hygienic Production</h6>
                    <p class="text-muted small mb-0">Proses produksi yang bersih dan terstandar.</p>
                </div>
            </div>
            <div class="why-item">
                <div class="why-icon"><i class="fa-solid fa-check"></i></div>
                <div>
                    <h6 class="fw-semibold mb-1">Satisfaction Guaranteed</h6>
                    <p class="text-muted small mb-0">Garansi kepuasan atau uang kembali.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="mb-5">
    <div class="section-header text-center mb-4">
        <h2 class="fw-bold">What Our Customers Say</h2>
        <p class="text-muted">Testimoni dari pelanggan setia kami</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="testimonial-card">
                <div class="testimonial-rating mb-2">
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                </div>
                <p class="testimonial-text">"suka bangeet snackbox nyaa!! bolunya enak dan rasanyaa beda banget sama bolu-bolu di tempat lain.
                    risoles bolognaise nya juga enakk bangeet, tadi dapet review dari tamu yg premium kalau isiannya mewah
                    intinya rating snack box 9,5/10 enak binggo sampe banyaak yg pengen nambah"</p>
                <div class="testimonial-author">
                    <img src="https://i.pravatar.cc/50?img=1" alt="Customer" class="testimonial-avatar">
                    <div>
                        <h6 class="mb-0 fw-semibold">Universitas Muhammadiyah Dr. Hamka</h6>
                        <small class="text-muted">Jakarta</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
                <div class="testimonial-rating mb-2">
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                </div>
                <p class="testimonial-text">"Roti, risol, dadar gulungnyaa enak semuaa.. anak" & volunteer pd sukaa!!
                    Pengirimannya jg pas bgtt ga telatt dan ga repott (karna jujur aku ga terus"an buka hp gituu untuk cek konsum udh dmn)
                    tbtb udh sampee ajaa depan Rumah Belajarnya"</p>
                <div class="testimonial-author">
                    <img src="https://i.pravatar.cc/50?img=3" alt="Customer" class="testimonial-avatar">
                    <div>
                        <h6 class="mb-0 fw-semibold">Kominitas Kindy Seeds</h6>
                        <small class="text-muted">Bandung</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
                <div class="testimonial-rating mb-2">
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star-half-stroke text-warning"></i>
                </div>
                <p class="testimonial-text">"enakkkk bgttt kaak susnya, tekstur flanya lembut banget,kayak ice cream creamy bgtt."</p>
                <div class="testimonial-author">
                    <img src="https://i.pravatar.cc/50?img=5" alt="Customer" class="testimonial-avatar">
                    <div>
                        <h6 class="mb-0 fw-semibold">Ulan</h6>
                        <small class="text-muted">Depok</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter-section mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h3 class="fw-bold mb-2">Join Our Sweet Community! 🍩</h3>
            <p class="text-muted mb-0">Dapatkan promo eksklusif dan info produk terbaru langsung ke email kamu.</p>
        </div>
        <div class="col-lg-6">
            <form class="newsletter-form d-flex gap-2 mt-3 mt-lg-0">
                <input type="email" class="form-control input-newsletter" placeholder="Masukkan email kamu" required>
                <button type="submit" class="btn btn-pink px-4">
                    <i class="fa-solid fa-paper-plane me-1"></i> Subscribe
                </button>
            </form>
        </div>
    </div>
</section>

@endsection