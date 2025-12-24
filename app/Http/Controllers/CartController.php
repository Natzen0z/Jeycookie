<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    # Halaman keranjang
    public function index()
    {
        # Dummy data keranjang
        $cartItems = [
            [
                'name' => 'Choco Cookie',
                'price' => 15000,
                'quantity' => 2
            ]
        ];

        return view('cart.index', compact('cartItems'));
    }

    # Tambah ke keranjang
    public function add(Request $request)
    {
        # Dummy action
        return redirect()->route('cart.index')
            ->with('success', 'Produk ditambahkan ke keranjang');
    }
}
