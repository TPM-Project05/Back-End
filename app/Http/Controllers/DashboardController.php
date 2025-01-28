<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Models\Team;
use App\Models\Member;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class DashboardController extends Controller
{
    /**
     * Mengambil user yang sedang login berdasarkan token JWT.
     */
    public function getUser()
    {
        try {
            // Coba autentikasi user dari token JWT
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404); // Jika user tidak ditemukan
            }
        } catch (JWTException $e) {
            // Menangani error saat parsing token
            return response()->json(['error' => 'Invalid token'], 400);
        }

        // Jika berhasil, kembalikan data user
        return response()->json(['user' => $user], 200);
    }
    
    /**
     * Mengambil semua data leaders dalam format JSON.
     */
    public function leaders()
    {
        $leaders = Leader::all();
        return response()->json(['leaders' => $leaders], 200); // Mengembalikan data leaders
    }

    /**
     * Mengambil semua data leaders dan users dalam format JSON,
     * hanya berdasarkan team_id yang sesuai dengan id login.
     */
    public function index()
    {
        try {
            // Coba autentikasi user dari token JWT
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404); // Jika user tidak ditemukan
            }

            // Mengambil data leader yang terkait dengan team_id
            $leader = Leader::where('team_id', $user->id)->first();

            // Mengambil data members yang terkait dengan team_id
            $members = Member::where('team_id', $user->id)->get();

            // Mengembalikan data leader, members, dan team yang sesuai dengan pengguna login
            return response()->json([
                'team' => $user, // Data team
                'leader' => $leader, // Data leader
                'members' => $members, // Data anggota lainnya
            ], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400); // Menangani error saat parsing token
        }
    }
}
