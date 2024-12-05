<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PaymentScreenshot extends Model
{
    use HasFactory;

    // Define the fillable attributes for the model
    protected $fillable = ['screenshot_path'];

    // Define the boot method to handle model events
    protected static function booted()
    {
        // Automatically delete the screenshot from storage when the model is deleted
        static::deleting(function ($paymentScreenshot) {
            // Ensure we are working with the correct file path relative to 'storage/app/public'
            $filePath = 'public/' . $paymentScreenshot->screenshot_path;

            // Check if the file exists in storage and delete it
            if (Storage::exists($filePath)) {
                Storage::delete($filePath); // Delete the file from storage
            }
        });
    }
}
