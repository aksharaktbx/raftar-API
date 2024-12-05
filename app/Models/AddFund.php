<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddFund extends Model
{
    use HasFactory;

    // Define the table name if different
    protected $table = 'add_funds';

    // Set the fillable fields to avoid mass-assignment issues
    protected $fillable = [
        'user_id',
        'amount',
        'utr_no',
        'image',
    ];


    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
