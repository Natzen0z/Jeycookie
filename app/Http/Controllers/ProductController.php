<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    # Halaman "Our Product"
    public function index()
    {
        # Dummy data produk
        $products = [
            [
                'id' => 1,
                'name' => 'Choco Cookie',
                'price' => 15000,
                'category' => 'Cookies'
            ],
            [
                'id' => 2,
                'name' => 'Vanilla Cake',
                'price' => 30000,
                'category' => 'Cake'
            ]
        ];

        return view('products.index', compact('products'));
    }

    # Halaman detail produk
    public function show($id)
    {
        # Dummy data produk
        $product = [
            'id' => $id,
            'name' => 'Choco Cookie',
            'price' => 15000,
            'description' => 'Cookie coklat lembut dan manis'
        ];

        return view('products.show', compact('product'));
    }
}
