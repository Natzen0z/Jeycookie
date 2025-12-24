<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    # Halaman homepage
    public function index()
    {
        $categories = ['Cookies', 'Cake', 'Dessert'];
        return view('home', compact('categories'));
    }
}
