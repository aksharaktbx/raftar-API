<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameChatsTable extends Migration
{
    public function up()
    {
        Schema::create('game_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key for the user
            $table->string('chart_url')->nullable(); // Chart URL (message removed)
            $table->timestamps();

            // Foreign key relationship with users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_chats');
    }
}
