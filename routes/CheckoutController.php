<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
    public function index()
    {
        // Dummy data keranjang
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

    /**
     * Proses buat pesanan
     */
    public function process(Request $request)
    {
        // Dummy proses pesanan
        // nanti: insert transaction, transaction_item, kirim email

        return redirect()->route('home')
            ->with('success', 'Pesanan berhasil dibuat, cek email kamu');
    }
}
