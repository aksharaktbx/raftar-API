<?php

// app/Models/Withdrawal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'payment_method', 'upi'];  // Include 'upi'

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
