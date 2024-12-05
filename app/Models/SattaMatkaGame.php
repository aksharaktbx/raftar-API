<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SattaMatkaGame extends Model
{
    use HasFactory;

    protected $table = 'satta_matka_games';

    protected $fillable = [
        'open_time_formatted',
        'close_time_formatted',
        'market_id',
        'market_name',
        'aankdo_date',
        'aankdo_open',
        'aankdo_close',
        'figure_open',
        'figure_close',
        'jodi',
        'open_time',
        'close_time'
    ];

    // Hide these fields in the response
    protected $hidden = [
        'updated_at',
        'created_at',
        'id'
    ];
}
