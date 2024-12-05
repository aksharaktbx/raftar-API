<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $table = 'bets';

    protected $fillable = [
        'user_id',
        'game_id',
        'game_name',
        'pana',
        'date',
        'totalbet',
        'bet',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(SattaMatkaGame::class, 'game_id');
    }
}
