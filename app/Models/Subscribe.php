<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan oleh model ini (jika berbeda dari default pluralized name)
    protected $table = 'subscribe';

    // Tentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = ['email'];

    // Jika kamu ingin menonaktifkan kolom timestamps (created_at dan updated_at)
    // public $timestamps = false;
}
