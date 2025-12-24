@extends('layouts.app')

@section('content')

<h2 class="mb-4">Our Product</h2>

<div class="row">
    @foreach ($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="https://via.placeholder.com/300x200" class="card-img-top">

                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="text-muted">Rp{{ number_format($product['price']) }}</p>

                    <a href="{{ route('products.show', $product['id']) }}" class="btn btn-primary btn-sm">
                        Detail
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
