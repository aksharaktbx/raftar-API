<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'gmail',
        'mobile_number',
        'facebook_link',
        'instagram_link',
        'telegram_link',
        'whatsapp_link',
    ];
}
