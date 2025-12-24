<h1>Checkout</h1>

<form method="POST" action="{{ route('checkout.process') }}">
    @csrf

    <input type="text" name="name" placeholder="Nama Lengkap"><br>
    <input type="text" name="phone" placeholder="Nomor Telepon"><br>
    <textarea name="address" placeholder="Alamat"></textarea><br>

    <h3>Produk</h3>
    @foreach ($cartItems as $item)
        <p>{{ $item['name'] }} ({{ $item['quantity'] }})</p>
    @endforeach

    <p>Total: Rp{{ $total }}</p>

    <button type="submit">Buat Pesanan</button>
</form>
