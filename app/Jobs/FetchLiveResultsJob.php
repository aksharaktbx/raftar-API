<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\GameResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchLiveResultsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Fetch live results via an API
        $response = Http::post('https://matkawebhook.matka-api.online/market-data', [
            'username' => '6350020360', 
            'API_token' => 'MJYJRHtCv9ftK9dB',
            'markte_name' => 'SITA MORNING',
            'date' => '2024-11-29',
        ]);

        // Check if response is successful
        if ($response->successful()) {
            $liveResults = $response->json()['today_result'];

            // Check if results exist
            if (!empty($liveResults)) {
                foreach ($liveResults as $result) {
                    $gameResult = GameResult::updateOrCreate(
                        [
                            'market_id' => $result['market_id'], 
                            'aankdo_date' => $result['aankdo_date']
                        ],
                        [
                            'market_name' => $result['market_name'],
                            'open_time' => $result['open_time'],
                            'close_time' => $result['close_time'],
                            'aankdo_open' => $result['aankdo_open'],
                            'aankdo_close' => $result['aankdo_close'],
                            'figure_open' => $result['figure_open'],
                            'figure_close' => $result['figure_close'],
                            'jodi' => $result['jodi'],
                        ]
                    );

                    // Log the inserted/updated data for debugging
                    Log::info("Game Result Inserted/Updated: " . json_encode($gameResult));
                }
            } else {
                Log::warning("No live results found for the given date and market.");
            }
        } else {
            Log::error("Failed to fetch data from external API. Status code: " . $response->status());
        }
    }
}
