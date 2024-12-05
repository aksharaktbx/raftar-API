<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    use HasFactory;

    // Define table name if different
    protected $table = 'user_otps';

    // Allow mass assignment for the columns
    protected $fillable = ['user_id', 'otp'];

    // Hide the timestamps if you don't need them in the response
    protected $hidden = ['created_at', 'updated_at'];

    // Relationship to User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
