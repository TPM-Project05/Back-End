<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'contact_us';

    // Menentukan kolom-kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
    ];

    // Jika kamu tidak ingin menggunakan timestamps, kamu bisa menonaktifkan fitur tersebut
    public $timestamps = true;

    // Jika kamu ingin menambahkan beberapa aksesori atau mutator, kamu bisa menambahkannya di sini
}
