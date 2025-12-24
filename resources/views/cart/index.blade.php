@extends('layouts.app')

@section('content')

<h2>Keranjang</h2>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        @php $total = 0; @endphp

        @foreach ($cartItems as $item)
            @php
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            @endphp
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>Rp{{ number_format($item['price']) }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>Rp{{ number_format($subtotal) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h4>Total: Rp{{ number_format($total) }}</h4>

<a href="{{ route('checkout.index') }}" class="btn btn-primary">
    Checkout
</a>

@endsection
