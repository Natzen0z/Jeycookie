@extends('layouts.app')
@section('title', 'About')

@section('content')

<h1 class="text-4xl font-bold text-pink-600 mb-6">About Us</h1>

<div class="grid md:grid-cols-2 gap-10 items-center">
    <div>
        <p class="text-gray-700 leading-relaxed">
            JeeyCookie adalah bakery lokal yang berdiri sejak 2020.
            Kami berkomitmen membuat donut & cookies premium dengan kualitas terbaik,
            tanpa bahan pengawet.
        </p>
        <p class="text-gray-700 mt-3">
            Visi kami adalah menghadirkan kebahagiaan melalui setiap gigitan.
        </p>
    </div>

    <img src="https://i.ibb.co/QkqZ4Bk/donut-box.png" class="rounded-xl shadow-lg w-80 md:w-96">
</div>

@endsection