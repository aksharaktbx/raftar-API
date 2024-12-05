<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    use HasFactory;

    protected $fillable = ['market_id', 'open', 'jodi', 'close'];

    public function market()
    {
        return $this->belongsTo(SattaMatkaGame::class, 'market_id');
    }
}
