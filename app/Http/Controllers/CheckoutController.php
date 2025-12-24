<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    # Halaman checkout
    public function index()
    {
        # Dummy data checkout
        $cartItems = [
            [
                'name' => 'Choco Cookie',
                'price' => 15000,
                'quantity' => 2
            ]
        ];

        $total = 30000;

        return view('checkout.index', compact('cartItems', 'total'));
    }

    # Proses checkout
    public function process(Request $request)
    {
        # Dummy proses transaksi
        return redirect()->route('home')
            ->with('success', 'Pesanan berhasil dibuat');
    }
}
