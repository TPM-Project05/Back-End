<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Menampilkan form contact us.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('contact_us.create'); // Tampilkan form input
    }

    /**
     * Menyimpan data contact us ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Simpan data ke database
        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Redirect dengan pesan sukses
        return response()->json([
            'message' => 'Contact us berhasil dikirim',
            
        ]);
    }
}