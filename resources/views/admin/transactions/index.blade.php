@extends('admin.layout')

@section('content')
    <!-- List transaksi -->
    <h2>Transaksi</h2>

    @foreach ($transactions as $trx)
        <p>
            #{{ $trx['id'] }} |
            {{ $trx['user'] }} |
            Rp{{ $trx['total'] }} |
            Status: {{ $trx['status'] }}
            <a href="{{ route('admin.transactions.show', $trx['id']) }}">Detail</a>
        </p>
    @endforeach
@endsection
