<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',    // The ID of the user who sent the message
        'chart_url',  // The URL for any associated chart or image
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
