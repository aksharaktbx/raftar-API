<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'username',
        'mobile_number',
        'password',
        'mpin',
        'state',
        'distic',
        'wallet_balance',
        'is_active',
        'photo',
        'email',
        'referral_code'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'mpin' => 'string',
        'wallet_balance' => 'float',
    ];

    public function addFunds()
    {
        return $this->hasMany(AddFund::class);
    }
}
