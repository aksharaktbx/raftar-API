<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSattaMatkaGamesTable extends Migration
{
    public function up()
    {
        Schema::create('satta_matka_games', function (Blueprint $table) {
            $table->id();
            $table->string('game_name');
            $table->string('open_time');
            $table->time('open_time_sort');
            $table->string('close_time');
            $table->integer('msg_status');
            $table->string('open_result')->nullable();
            $table->string('close_result')->nullable();
            $table->bigInteger('open_duration');
            $table->bigInteger('close_duration');
            $table->timestamp('time_srt');
            $table->string('web_chart_url');
            $table->text('note')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('satta_matka_games');
    }
}
