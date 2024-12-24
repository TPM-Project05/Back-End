<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function Laravel\Prompts\password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'name' => 'required|string|max:255',
                'age' => 'required |integer|min:17',
        'email' => 'required|email|unique:users,email',
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/[A-Z]/',       
            'regex:/[a-z]/',       
            'regex:/[0-9]/',       
            'regex:/[@$!%*?&#]/',  // tanda spesial 
            'confirmed',    // password harus cocok
        ],
        'password_confirmation' => 'required|string',
    'user_type' => 'required|in:binusian,non-binusian',
    ];
    }

    public function messages(): array
    {
        return [
            'age.required' => 'Kolom usia tidak boleh kosong!.',
        'age.integer' => 'Kolom usia harus berupa angka!.',
        'age.min' => 'usia minimal untuk mengikuti adalah 17 tahun !.',
            'password.min' => 'password harus minimal berjumlah 8 karakter!',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan tanda spesial!.',
            'password.confirmed' =>'Konfirmasi password tidak cocok!.',
            'user_type.required' =>'Pilih Binusan atau Non-binusian!.',
            'user_type.in' =>'Pilihan harus Binusian atau Non-binusian!.',

        ];
    }
}
