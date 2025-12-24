<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang
     */
    public function index()
    {
        // Dummy isi keranjang
        $cartItems = [
            [
                'name' => 'Choco Cookie',
                'price' => 15000,
                'quantity' => 2
            ]
        ];

        return view('cart.index', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang
     */
    public function add(Request $request)
    {
        // Dummy logic (nanti diganti insert DB)
        return redirect()->route('cart')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }
}
