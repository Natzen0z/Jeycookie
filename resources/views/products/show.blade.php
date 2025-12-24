@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <img src="https://via.placeholder.com/500x400" class="img-fluid rounded">
    </div>

    <div class="col-md-6">
        <h2>{{ $product['name'] }}</h2>
        <p class="text-muted">Rp{{ number_format($product['price']) }}</p>

        <p>{{ $product['description'] }}</p>

        <form method="POST" action="{{ route('cart.add') }}">
            @csrf

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="quantity" class="form-control w-25" value="1">
            </div>

            <button class="btn btn-success">
                Tambah ke Keranjang
            </button>
        </form>
    </div>
</div>

@endsection
