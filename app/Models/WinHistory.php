<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_name',
        'result',
        'open_time',
        'close_time',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Game
    public function game()
    {
        return $this->belongsTo(SattaMatkaGame::class, 'game_name', 'game_name');
    }
}
