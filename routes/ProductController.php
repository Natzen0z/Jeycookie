<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan semua produk
     */
    public function index()
    {
        // Ambil semua produk dari database
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan detail produk berdasarkan ID
     */
    public function show($id)
    {
        // Ambil produk, jika tidak ada → 404 otomatis
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }
}
