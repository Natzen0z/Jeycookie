@extends('admin.layout')

@section('content')
    <!-- Form tambah produk -->
    <h2>Tambah Produk</h2>

    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Nama Produk"><br>
        <input type="number" name="price" placeholder="Harga"><br>
        <input type="number" name="stock" placeholder="Stock"><br>

        <button type="submit">Simpan</button>
    </form>
@endsection
