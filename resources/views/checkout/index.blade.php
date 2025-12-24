@extends('layouts.app')

@section('content')

<h2>Checkout</h2>

<form method="POST" action="{{ route('checkout.process') }}">
    @csrf

    <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" class="form-control" name="name">
    </div>

    <div class="mb-3">
        <label>Nomor Telepon</label>
        <input type="text" class="form-control" name="phone">
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea class="form-control" name="address"></textarea>
    </div>

    <h5>Ringkasan Pesanan</h5>

    @foreach ($cartItems as $item)
        <p>{{ $item['name'] }} ({{ $item['quantity'] }})</p>
    @endforeach

    <p class="fw-bold">Total: Rp{{ number_format($total) }}</p>

    <button class="btn btn-success">
        Buat Pesanan
    </button>
</form>

@endsection
