<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('how_to_play_videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_link', 255); // Store the YouTube video link
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('how_to_play_videos');
    }
};
