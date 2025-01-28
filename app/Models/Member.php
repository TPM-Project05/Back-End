<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'phone', 'line_id', 'github_id', 'birth_place', 'birth_date', 'cv', 'flazz_card', 'team_id'
    ];

    /**
     * Relasi ke Team (anggota tim terkait dengan satu tim).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id'); // Anggota terkait dengan tim melalui team_id
    }
}

