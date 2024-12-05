<?php

// database/seeders/SattaMatkaGameSeeder.php

namespace Database\Seeders;

use App\Models\SattaMatkaGame;
use Illuminate\Database\Seeder;

class SattaMatkaGameSeeder extends Seeder
{
    public function run()
    {
        $games = [
            [
                'game_name' => 'MILAN MORNING',
                'open_time' => '10:15 AM',
                'open_time_sort' => '10:15:00',
                'close_time' => '11:15 AM',
                'msg_status' => 2,
                'open_result' => '',
                'close_result' => '',
                'open_duration' => 12411000,
                'close_duration' => 8811000,
                'time_srt' => date('Y-m-d H:i:s', 1731559500), // Convert to DATETIME
                'web_chart_url' => 'https://sattamatkachart.in/record/milan-day-chart.php',
                'note' => '',
                'user_id' => 1,
                'msg' => 'Market Closed'  // Add msg field with value
            ],
            [
                'game_name' => 'RAJDHANI DAY',
                'open_time' => '1:00 PM',
                'open_time_sort' => '13:00:00',
                'close_time' => '2:00 PM',
                'msg_status' => 2,
                'open_result' => '',
                'close_result' => '',
                'open_duration' => 1800000,
                'close_duration' => 1800000,
                'time_srt' => date('Y-m-d H:i:s', 1731559700), // Convert to DATETIME
                'web_chart_url' => 'https://sattamatkachart.in/record/rajdhani-day-chart.php',
                'note' => '',
                'user_id' => 1,
                'msg' => 'Market Open'  // Add msg field with value
            ],
            // Add the rest of the games here similarly
        ];

        foreach ($games as $game) {
            SattaMatkaGame::create($game);
        }
    }
}
