<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    public function store(Request $request)
    {
        // Simpan data partnership
        // Jika kamu sudah punya tabel, tinggal sesuaikan modelnya

        // contoh tanpa database dulu:
        // dd($request->all());

        return back()->with('success', 'Pengajuan partnership berhasil dikirim!');
    }
}
