<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // This is the primary key, no need to redefine it
            $table->string('username', 191)->unique();
            $table->string('mobile_number', 191)->unique();
            $table->string('password');
            $table->string('mpin', 4);
            $table->timestamps();
        });
    }

    public function down(): voids
    {
        Schema::dropIfExists('users');
    }
};
