<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HalfSangamBet extends Model
{
    use HasFactory;

    protected $table = 'half_sangam_bets';

    protected $fillable = [
        'user_id',
        'game_id',
        'game_name',
        'pana',
        'date',
        'totalbet',
        'bet',
        'opendigit',
        'closedigit'
    ];
}
