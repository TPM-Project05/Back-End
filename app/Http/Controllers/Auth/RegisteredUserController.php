<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        // Validasi data dari RegisterRequest
        $validatedData = $request->validated();

        // Buat pengguna baru
        $user = User::create([
            'name' => $validatedData['name'],
            'age' => $validatedData['age'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'user_type' => $validatedData['user_type'] ?? 'default', // Tambahkan tipe pengguna jika diperlukan
        ]);

        // Event untuk user terdaftar
        event(new Registered($user));

        // Login user setelah registrasi
        Auth::login($user);

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }
}
