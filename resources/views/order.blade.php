@extends('layouts.app')
@section('title', 'Order')

@section('content')

<h1 class="text-4xl font-bold text-pink-600 mb-8">Order Now 🍩</h1>

<div class="grid md:grid-cols-3 gap-10">

    {{-- ITEM 1 --}}
    <div class="bg-white p-6 rounded-2xl shadow">
        <img src="https://i.ibb.co/gWP7P8w/donut-pink.png" class="w-40 mx-auto">
        <h3 class="text-xl font-bold text-center mt-4 text-pink-600">Pink Donut</h3>
        <p class="text-center text-gray-600">Rp 15.000</p>
        <button class="btn-main w-full mt-4">Add to Cart</button>
    </div>

    {{-- ITEM 2 --}}
    <div class="bg-white p-6 rounded-2xl shadow">
        <img src="https://i.ibb.co/XpkvLDY/donut-choco.png" class="w-40 mx-auto">
        <h3 class="text-xl font-bold text-center mt-4 text-pink-600">Chocolate Donut</h3>
        <p class="text-center text-gray-600">Rp 17.000</p>
        <button class="btn-main w-full mt-4">Add to Cart</button>
    </div>

    {{-- ITEM 3 --}}
    <div class="bg-white p-6 rounded-2xl shadow">
        <img src="https://i.ibb.co/d4tHNgT/cookie-choco.png" class="w-40 mx-auto">
        <h3 class="text-xl font-bold text-center mt-4 text-pink-600">Chocolate Cookies</h3>
        <p class="text-center text-gray-600">Rp 12.000</p>
        <button class="btn-main w-full mt-4">Add to Cart</button>
    </div>

</div>

@endsection