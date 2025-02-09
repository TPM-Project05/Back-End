<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Leader;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{


    /**
     * Edit Member berdasarkan ID
     */

    
    public function updateMember(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|digits_between:9,15|unique:members,phone,' . $id,
            'line_id' => 'nullable|string|unique:members,line_id,' . $id,
            'github_id' => 'nullable|string|max:255',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before_or_equal:' . now()->subYears(17)->format('Y-m-d'),
            'cv' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',  // Validasi untuk CV
            'flazz_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',  // Validasi untuk flazz_card
        ]);
    
        // Cari Member berdasarkan ID
        $member = Member::findOrFail($id);
    
        // Handle file upload (CV dan flazz_card)
        $cvPath = $member->cv;
        if ($request->hasFile('cv')) {
            // Hapus file lama jika ada
            if ($cvPath) {
                Storage::delete($cvPath);
            }
            // Simpan file baru ke disk 'public'
            $cvPath = $request->file('cv')->storePublicly('cv', 'public');
        }
    
        $flazzCardPath = $member->flazz_card;
        if ($request->hasFile('flazz_card')) {
            // Hapus file lama jika ada
            if ($flazzCardPath) {
                Storage::delete($flazzCardPath);
            }
            // Simpan file baru ke disk 'public'
            $flazzCardPath = $request->file('flazz_card')->storePublicly('flazz_card', 'public');
        }
    
        // Update data Member
        $member->update($request->only([
            'full_name',
            'phone',
            'line_id',
            'github_id',
            'birth_place',
            'birth_date',
        ]) + [
            'cv' => $cvPath,  // Menyimpan path file CV
            'flazz_card' => $flazzCardPath,  // Menyimpan path file Flazz Card
        ]);
    
        return response()->json(['message' => 'Member updated successfully', 'member' => $member], 200);

    }
    public function create()
    {
        return view('auth.leaders');
    }

    public function editLeaders(Request $request, $id)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                'phone' => 'nullable|digits_between:9,15|unique:leaders,phone,' . $id,
                'line_id' => 'nullable|string|unique:leaders,line_id,' . $id,
                'github_id' => 'nullable|string|max:255',
                'birth_place' => 'nullable|string|max:255',
                'birth_date' => 'nullable|date|before_or_equal:' . now()->subYears(17)->format('Y-m-d'),
                'cv' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi CV
                'flazz_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi flazz_card
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Kembalikan response JSON dengan error validasi
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }
    
        // Cari Leaders berdasarkan ID
        $leader = Leader::findOrFail($id);
    
        // Handle file upload (CV)
        $cvPath = $leader->cv;
        if ($request->hasFile('cv')) {
            // Hapus file lama jika ada
            if ($cvPath) {
                Storage::delete($cvPath);
            }
            // Simpan file baru ke disk 'public'
            $cvPath = $request->file('cv')->storePublicly('cv', 'public');
        }
    
        // Handle file upload (Flazz Card)
        $flazzCardPath = $leader->flazz_card;
        if ($request->hasFile('flazz_card')) {
            // Hapus file lama jika ada
            if ($flazzCardPath) {
                Storage::delete($flazzCardPath);
            }
            // Simpan file baru ke disk 'public'
            $flazzCardPath = $request->file('flazz_card')->storePublicly('flazz_card', 'public');
        }
    
        // Update data Leader
        $leader->update($validatedData + [
            'cv' => $cvPath,        // Menyimpan path file CV
            'flazz_card' => $flazzCardPath, // Menyimpan path file Flazz Card
        ]);
    
        // Debug data untuk memastikan input diterima dengan benar
        dd($request->all());
    
        // Response JSON sukses
        return response()->json([
            'message' => 'Leader updated successfully',
            'leader' => $leader,
        ], 200);
    }
    


    /**
     * Edit Team berdasarkan ID
     */
    public function editTeam(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:teams,email,' . $id,
            'role' => 'nullable|string|in:admin,non-binusian,binusian',
            'status' => 'nullable|string|in:active,inactive',
            'leader_id' => 'nullable|exists:members,id',
        ]);

        // Cari Team berdasarkan ID
        $team = Team::findOrFail($id);

        // Update data Team
        $team->update($request->only([
            'name',
            'email',
            'role',
            'status',
            'leader_id',
        ]));

        return response()->json(['message' => 'Team updated successfully', 'team' => $team], 200);
    }

    public function deleteTeam($id)
    {
        // Cari Team berdasarkan ID
        $team = Team::find($id);

        // Jika Team tidak ditemukan
        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        // Hapus Team (otomatis menghapus Member dan Leader terkait melalui cascade)
        $team->delete();

        return response()->json(['message' => 'Team and related data deleted successfully'], 200);
    }

    public function deleteMember($id)
    {
        // Cari Member berdasarkan ID
        $member = Member::find($id);

        // Jika Member tidak ditemukan
        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        // Hapus Member
        $member->delete();

        return response()->json(['message' => 'Member deleted successfully'], 200);
    }

    /**
     * Hapus data Leader berdasarkan ID
     */
    public function deleteLeader($id)
    {
        // Cari Leader berdasarkan ID
        $leader = Leader::find($id);

        // Jika Leader tidak ditemukan
        if (!$leader) {
            return response()->json(['message' => 'Leader not found'], 404);
        }

        // Hapus Leader
        $leader->delete();

        return response()->json(['message' => 'Leader deleted successfully'], 200);
    }

    
}
