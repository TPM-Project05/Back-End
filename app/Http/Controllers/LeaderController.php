<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leader;

class LeaderController extends Controller
{
    public function create()
    {
        return view('auth.leaders');
    }
    
    public function store(Request $request)
    {
        // Aturan validasi
        $request->validate(
            [
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:leaders,email|max:255',
                'phone' => 'required|digits_between:9,15|unique:leaders,phone',
                'line_id' => 'required|string|unique:leaders,line_id|max:255',
                'github_id' => 'required|string|max:255',
                'birth_place' => 'required|string|max:255',
                'birth_date' => [
                    'required',
                    'date',
                    'before_or_equal:' . now()->subYears(17)->format('Y-m-d'),
                ],
                'cv' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'flazz_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'id_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ],
            [
                'full_name.required' => 'Nama lengkap wajib diisi',
                'full_name.string' => 'Nama lengkap harus berupa string',
                'full_name.max' => 'Nama lengkap maksimal 255 karakter',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Email harus berupa email',
                'email.unique' => 'Email sudah terdaftar',
                'email.max' => 'Email maksimal 255 karakter',
                'phone.required' => 'Nomor telepon wajib diisi',
                'phone.digits_between' => 'Nomor telepon harus berupa angka dengan panjang 9-15 karakter',
                'phone.unique' => 'Nomor telepon sudah terdaftar',
                'line_id.required' => 'ID Line wajib diisi',
                'line_id.string' => 'ID Line harus berupa huruf',
                'line_id.unique' => 'ID Line sudah terdaftar',
                'line_id.max' => 'ID Line maksimal 255 karakter',
                'github_id.required' => 'ID Github wajib diisi',
                'github_id.string' => 'ID Github harus berupa string',
                'github_id.max' => 'ID Github maksimal 255 karakter',
                'birth_place.required' => 'Tempat lahir wajib diisi',
                'birth_place.string' => 'Tempat lahir harus berupa string',
                'birth_place.max' => 'Tempat lahir maksimal 255 karakter',
                'birth_date.required' => 'Tanggal lahir wajib diisi',
                'birth_date.date' => 'Tanggal lahir harus berupa tanggal',
                'birth_date.before_or_equal' => 'Usia minimal 17 tahun',
                'cv.required' => 'CV wajib diisi',
                'cv.file' => 'CV harus berupa file',
                'cv.mimes' => 'CV harus berupa file pdf, jpg, jpeg, atau png',
                'cv.max' => 'CV maksimal 2MB',
                'flazz_card.file' => 'Flazz Card harus berupa file',
                'flazz_card.mimes' => 'Flazz Card harus berupa file pdf, jpg, jpeg, atau png',
                'flazz_card.max' => 'Flazz Card maksimal 2MB',
            ]
        );

        // Menyimpan file ke storage
        \App\Models\Leader::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'line_id' => $request->line_id,
            'github_id' => $request->github_id,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'cv' => $request->file('cv')->store('cv'),
            'flazz_card' => $request->file('flazz_card') ? $request->file('flazz_card')->store('flazz_card') : null,
            'id_card' => $request->file('id_card') ? $request->file('id_card')->store('id_card') : null,
            'leader=>leader',
        ]);

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan');
    }
}
