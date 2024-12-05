<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'transaction_type', 'amount', 'transaction_date'];  // Added transaction_date

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
