<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Leader extends Model 
{
    use HasFactory;

    protected $fillable = ['full_name', 'phone', 'line_id', 'github_id', 'birth_place', 'birth_date', 'cv', 'flazz_card', 'team_id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke model Member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // Di model Leader
    public function team()
    {
        return $this->hasOne(Team::class, 'leader_id');  // Leader hanya memimpin satu tim
    }

    /**
     * Menghitung jumlah anggota tim.
     *
     * @return int
     */
    public function getMemberCountAttribute()
    {
        return $this->members()->count(); // Menghitung jumlah anggota berdasarkan relasi
    }

}
