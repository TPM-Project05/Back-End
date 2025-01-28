<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberController extends Controller
{
    // Menambahkan middleware untuk memverifikasi token JWT
    public function create()
    {
        return view('auth.members');
    }

    public function store(Request $request)
    {
        // Ambil data pengguna yang terautentikasi (Team)
        $team = auth()->user(); // Mengambil tim berdasarkan pengguna yang sedang login

        if (!$team) {
            return response()->json(['error' => 'User not authenticated or team not found'], 401);
        }

        // Validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|digits_between:9,15|unique:members,phone',
            'line_id' => 'required|string|unique:members,line_id|max:255',
            'github_id' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(17)->format('Y-m-d'),
            ],
            'cv' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'flazz_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi',
            'line_id.required' => 'ID Line wajib diisi',
            'github_id.required' => 'ID GitHub wajib diisi',
            'birth_place.required' => 'Tempat lahir wajib diisi',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'cv.required' => 'CV wajib diunggah',
        ]);

        // Menyimpan data anggota ke tabel `members` (Tidak perlu leader_id)
        $member = Member::create([
            'team_id' => $team->id, // Menghubungkan dengan tim berdasarkan pengguna yang login
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'line_id' => $request->line_id,
            'github_id' => $request->github_id,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'cv' => $request->file('cv')->store('cv'),
            'flazz_card' => $request->file('flazz_card') ? $request->file('flazz_card')->store('flazz_card') : null,
            'status' => 'member', // Status anggota biasa
        ]);

        return response()->json([
            'message' => 'Data anggota berhasil disimpan',
            'member' => $member,
            'team' => $team,
        ]);
    }
}
