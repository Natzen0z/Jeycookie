@extends('admin.layout')

@section('content')
    <!-- Halaman list produk -->
    <h2>Manajemen Produk</h2>

    <a href="{{ route('admin.products.create') }}">Tambah Produk</a>

    <ul>
        @foreach ($products as $product)
            <li>
                {{ $product['name'] }} |
                Rp{{ $product['price'] }} |
                Stock: {{ $product['stock'] }}
            </li>
        @endforeach
    </ul>
@endsection
