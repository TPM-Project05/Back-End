<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;


class JWTAuthController extends Controller
{
    // Register Team
    public function register(Request $request)
    {
        // Validasi inputan request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teams',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'string', // Role bisa berupa 'admin', 'user', dsb.
            'status' => 'required|string', // Status bisa berupa 'active', 'inactive', dsb.
            'leader_id' => 'nullable|integer|exists:users,id', // Jika memiliki pemimpin tim
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        // Menambahkan nilai 'role', 'status', dan 'leader_id' jika ada
        $team = Team::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => $request->get('role', 'participant'),
            'status' => $request->get('status'),
            'leader_id' => $request->get('leader_id'), // Leader jika ada
        ]);

        return response()->json(compact('team'), 201);
    }

    // Login Team
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    try {
        // Cek apakah kredensial valid dan buat token JWT
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $team = Auth::user();


        // Menambahkan klaim tambahan pada token (jika perlu)
        $token = JWTAuth::claims([
            'id' => $team->id,
            'role' => $team->role,
            'name' => $team->name,
            'status' => $team->status,
        ])->fromUser($team);

        return response()->json(compact('token'));  // Mengembalikan token
    } catch (JWTException $e) {
        return response()->json(['error' => 'Could not create token'], 500);
    }
}



    // Get authenticated Team
    public function getUser()
    {
        try {
            if (! $team = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'Team not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('team'));
    }

    // Logout Team
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    // Refresh JWT Token
    public function refresh()
    {
        $token = Auth::refresh();

        return response()->json([
            "status" => true,
            "message" => "New access token",
            "token" => $token,
            "expires_in" => Auth::factory()->getTTL() * 60
        ]);
    }
}
