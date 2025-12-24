<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminTransactionController extends Controller
{
    public function index()
    {
        # Dummy list transaksi
        $transactions = [
            [
                'id' => 1,
                'user' => 'John Doe',
                'total' => 30000,
                'status' => 'pending'
            ]
        ];

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        # Dummy detail transaksi
        $transaction = [
            'id' => $id,
            'user' => 'John Doe',
            'total' => 30000,
            'status' => 'pending'
        ];

        $items = [
            [
                'product' => 'Choco Cookie',
                'price' => 15000,
                'quantity' => 2
            ]
        ];

        return view('admin.transactions.show', compact(
            'transaction',
            'items'
        ));
    }
}
