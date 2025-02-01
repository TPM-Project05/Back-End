<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;

class SubscribeController extends Controller
{
    /**
     * Menyimpan data subscribe ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:subscribes,email',
        ]);

        // Simpan data ke database
        Subscribe::create([
            'email' => $request->email,
        ]);

        // Redirect dengan pesan sukses
        return response()->json([
            'message' => 'Kamu berhasil berlangganan',
        ]);
    }
}