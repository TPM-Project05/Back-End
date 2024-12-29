<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaderController extends Controller
{
    public function showForm()
    {
        // Menampilkan form leader
        return view('leader-form');
    }

    public function submitLeaderData(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:leaders,email',
            'whatsapp_number' => 'required|numeric|digits_between:9,15|unique:leaders,whatsapp_number',
            'line_id' => 'required|string|max:255|unique:leaders,line_id',
            'github_gitlab_id' => 'required|string|max:255',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date|before:' . now()->subYears(17),
            'cv' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'flazz_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'id_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Simpan data ke database (opsional)
        // Leader::create($validated);

        // Redirect ke halaman sukses
        return redirect()->route('dashboard')->with('success', 'Data leader berhasil disimpan!');
    }
}
