<h1>Our Product</h1>

@foreach ($products as $product)
    <div>
        <h3>{{ $product['name'] }}</h3>
        <p>Harga: Rp{{ $product['price'] }}</p>
        <a href="{{ route('products.show', $product['id']) }}">Detail</a>
    </div>
@endforeach
