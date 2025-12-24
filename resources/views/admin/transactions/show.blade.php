@extends('admin.layout')

@section('content')
    <!-- Detail transaksi -->
    <h2>Detail Transaksi #{{ $transaction['id'] }}</h2>

    <p>User: {{ $transaction['user'] }}</p>
    <p>Status: {{ $transaction['status'] }}</p>
    <p>Total: Rp{{ $transaction['total'] }}</p>

    <h3>Item</h3>
    @foreach ($items as $item)
        <p>
            {{ $item['product'] }} -
            {{ $item['quantity'] }} x Rp{{ $item['price'] }}
        </p>
    @endforeach
@endsection
