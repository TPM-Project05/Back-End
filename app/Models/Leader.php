<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user;


class Leader extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'line_id',
        'github_id',
        'birth_place',
        'birth_date',
        'cv',
        'flazz_card',
        'id_card'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
