<h1>{{ $product['name'] }}</h1>

<p>{{ $product['description'] }}</p>
<p>Harga: Rp{{ $product['price'] }}</p>

<form method="POST" action="{{ route('cart.add') }}">
    @csrf
    <input type="number" name="quantity" value="1">
    <button type="submit">Tambah ke Keranjang</button>
</form>
