<h1>Keranjang</h1>

@foreach ($cartItems as $item)
    <p>
        {{ $item['name'] }} -
        {{ $item['quantity'] }} x Rp{{ $item['price'] }}
    </p>
@endforeach

<a href="{{ route('checkout') }}">Checkout</a>
