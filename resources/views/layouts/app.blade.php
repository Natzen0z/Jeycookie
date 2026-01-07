<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Jeycookie') }} - @yield('title', 'Fresh Bakery')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Tailwind CSS + DaisyUI -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-base-200">

    <!-- NAVBAR -->
    <navbar class="navbar sticky top-0 z-50 bg-base-100 shadow-lg">
        <div class="navbar-start">
            <div class="dropdown">
                <button class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
                </button>
                <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ url('/about') }}">About</a></li>
                </ul>
            </div>
            <a href="{{ url('/') }}" class="btn btn-ghost text-xl gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Jeycookie" class="h-8 w-auto">
                Jeycookie
            </a>
        </div>

        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">Products</a></li>
                <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a></li>
            </ul>
        </div>

        <div class="navbar-end gap-2">
            <div class="indicator">
                <a href="{{ route('cart.index') }}" class="btn btn-ghost btn-circle">
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="indicator-item badge badge-primary badge-sm">{{ $cartCount }}</span>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </a>
            </div>

            @guest
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
            @else
                <div class="dropdown dropdown-end">
                    <button class="btn btn-primary btn-sm gap-2">
                        {{ Auth::user()->name }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                        @if(Auth::user()->is_admin)
                            <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </navbar>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success mb-4 shadow-lg">
            <i class="fas fa-check-circle text-lg"></i>
            <div>
                <h3 class="font-bold">Success!</h3>
                <div class="text-sm">{{ session('success') }}</div>
            </div>
            <button class="btn btn-sm btn-ghost" onclick="this.parentElement.style.display='none'">Close</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error mb-4 shadow-lg">
            <i class="fas fa-exclamation-circle text-lg"></i>
            <div>
                <h3 class="font-bold">Error!</h3>
                <div class="text-sm">{{ session('error') }}</div>
            </div>
            <button class="btn btn-sm btn-ghost" onclick="this.parentElement.style.display='none'">Close</button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning mb-4 shadow-lg">
            <i class="fas fa-exclamation-triangle text-lg"></i>
            <div>
                <h3 class="font-bold">Warning!</h3>
                <div class="text-sm">{{ session('warning') }}</div>
            </div>
            <button class="btn btn-sm btn-ghost" onclick="this.parentElement.style.display='none'">Close</button>
        </div>
    @endif

    <!-- MAIN CONTENT -->
    <main class="min-h-screen py-8">
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer footer-center bg-gray-900 text-white p-10">
        <div class="w-full">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 w-full">
                <!-- Brand -->
                <div class="text-left">
                    <div class="flex items-center gap-2 mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Jeycookie" class="h-10 w-auto">
                        <span class="text-lg font-bold">Jeycookie</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">Fresh homemade bakery products made with love. Premium ingredients, baked fresh daily.</p>
                    <div class="flex gap-4">
                        <a href="#" class="link link-hover text-pink-500 text-lg"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="link link-hover text-pink-500 text-lg"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="link link-hover text-pink-500 text-lg"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="text-left">
                    <h2 class="footer-title">Quick Links</h2>
                    <a href="{{ url('/') }}" class="link link-hover text-gray-400 hover:text-pink-500">Home</a>
                    <a href="{{ route('products.index') }}" class="link link-hover text-gray-400 hover:text-pink-500">Products</a>
                    <a href="{{ url('/about') }}" class="link link-hover text-gray-400 hover:text-pink-500">About Us</a>
                </div>

                <!-- Categories -->
                <div class="text-left">
                    <h2 class="footer-title">Categories</h2>
                    <a href="#" class="link link-hover text-gray-400 hover:text-pink-500">Sweet</a>
                    <a href="#" class="link link-hover text-gray-400 hover:text-pink-500">Savory</a>
                    <a href="#" class="link link-hover text-gray-400 hover:text-pink-500">Donut</a>
                    <a href="#" class="link link-hover text-gray-400 hover:text-pink-500">Traditional Cake</a>
                </div>

                <!-- Contact -->
                <div class="text-left">
                    <h2 class="footer-title">Contact Us</h2>
                    <p class="text-gray-400"><i class="fas fa-map-marker-alt text-pink-500 mr-2"></i>Jakarta, Indonesia</p>
                    <p class="text-gray-400"><i class="fas fa-phone text-pink-500 mr-2"></i>+62 812-3456-7890</p>
                    <p class="text-gray-400"><i class="fas fa-envelope text-pink-500 mr-2"></i>hello@jeycookie.com</p>
                </div>
            </div>

            <div class="divider my-4"></div>

            <div class="text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Jeycookie. All rights reserved. Freshly baked with <i class="fas fa-heart text-red-500"></i></p>
            </div>
        </div>
    </footer>

    <!-- Midtrans Snap Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <!-- Quick Buy Modal -->
    @include('checkout.quick-buy-modal')

    @stack('scripts')
</body>

</html>

