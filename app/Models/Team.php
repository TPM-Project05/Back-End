<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Member;
use Illuminate\Auth\Authenticatable as LaravelAuthenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class Team extends Authenticatable implements JWTSubject
{
    use LaravelAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'identity',
        'role',
        'status',
        'member',
        'leader_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Leader (setiap tim memiliki satu leader).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(Leader::class, 'leader_id');  // Setiap tim memiliki satu leader
        return $this->hasOne(Leader::class, 'team_id');
    }   

    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where('name', 'like', "%{$term}%");
        }
    }

    // Scope untuk pengurutan
    public function scopeSort($query, $sortField, $sortDirection)
    {
        $validFields = ['name', 'created_at']; // Field yang valid untuk sorting
        $sortField = in_array($sortField, $validFields) ? $sortField : 'name'; // Default ke 'name'
        $sortDirection = $sortDirection === 'desc' ? 'desc' : 'asc'; // Default ke 'asc'

        return $query->orderBy($sortField, $sortDirection);
    }

    /**
     * Relasi ke Members (anggota tim yang bukan leader).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'team_id'); // Mengambil anggota tim berdasarkan team_id
    }

    /**
     * Fungsi untuk menghitung total anggota (termasuk leader).
     *
     * @return int
     */
    public function totalMembers()
    {
        return $this->members()->count() + 1; // 1 ditambahkan untuk leader
    }

    /**
     * Mendapatkan identifier JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Mendapatkan klaim kustom untuk JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
