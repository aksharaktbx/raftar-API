<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_msg_to_satta_matka_games_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMsgToSattaMatkaGamesTable extends Migration
{
    public function up()
    {
        Schema::table('satta_matka_games', function (Blueprint $table) {
            $table->string('msg')->nullable();  // Add the msg column
        });
    }

    public function down()
    {
        Schema::table('satta_matka_games', function (Blueprint $table) {
            $table->dropColumn('msg');  // Drop the msg column if rollback
        });
    }
}
