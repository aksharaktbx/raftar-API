<?php 

// database/migrations/2024_11_12_134618_create_add_funds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddFundsTable extends Migration
{
    public function up()
    {
        Schema::create('add_funds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key
            $table->decimal('amount', 10, 2); // Amount to be added
            $table->string('payment_method'); // Payment method (e.g., 'credit card', 'paypal')
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('add_funds');
    }
}
