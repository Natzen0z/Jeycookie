<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    # Menampilkan homepage
    public function index()
    {
        $categories = ['Cookies', 'Cake', 'Dessert'];
        return view('home', compact('categories'));
    }
}
