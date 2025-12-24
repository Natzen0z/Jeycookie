<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        # Dummy data ringkasan dashboard
        $totalUsers = 10;
        $totalProducts = 8;
        $totalTransactions = 5;

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalTransactions'
        ));
    }
}
