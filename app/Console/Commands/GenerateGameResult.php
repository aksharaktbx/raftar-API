<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GameResult;
use App\Models\SattaMatkaGame;
use Carbon\Carbon;

class GenerateGameResult extends Command
{
  protected $signature = 'game:generate-result';
  protected $description = 'Generate or Update game result automatically every minute';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {

    $market = SattaMatkaGame::inRandomOrder()->first();

    if ($market) {
      $open = rand(100, 999);
      $jodi = rand(10, 99);
      $close = rand(100, 999);
      $existingResult = GameResult::where('market_id', $market->id)->first();
      if ($existingResult) {
        $existingResult->update([
          'open' => $open,
          'jodi' => $jodi,
          'close' => $close,
        ]);
        $this->info("Game result updated for market ID {$market->id}.");
      } else {
        GameResult::create([
          'market_id' => $market->id,
          'open' => $open,
          'jodi' => $jodi,
          'close' => $close,
        ]);
        $this->info("New game result created for market ID {$market->id}.");
      }
    } else {
      $this->error('No market found for result generation.');
    }
  }
}
