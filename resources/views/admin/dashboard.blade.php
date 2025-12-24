@extends('admin.layout')

@section('content')
    <!-- Ringkasan data admin -->
    <h2>Dashboard</h2>

    <p>Total User: {{ $totalUsers }}</p>
    <p>Total Produk: {{ $totalProducts }}</p>
    <p>Total Transaksi: {{ $totalTransactions }}</p>
@endsection
