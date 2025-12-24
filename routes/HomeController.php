<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman homepage
     */
    public function index()
    {
        // Dummy kategori (nanti bisa dari database)
        $categories = ['Cookies', 'Cake', 'Dessert'];

        return view('home', compact('categories'));
    }
}
