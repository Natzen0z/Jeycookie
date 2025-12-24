<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        # Dummy list produk
        $products = [
            [
                'id' => 1,
                'name' => 'Choco Cookie',
                'price' => 15000,
                'stock' => 20
            ],
            [
                'id' => 2,
                'name' => 'Vanilla Cake',
                'price' => 30000,
                'stock' => 10
            ]
        ];

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        # Form tambah produk
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        # Dummy simpan produk
        # nanti: validasi + insert ke table product

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil ditambahkan');
    }
}
