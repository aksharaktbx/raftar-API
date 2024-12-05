<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\User;
use App\Models\HalfSangamBet;
use App\Models\SattaMatkaGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BetController extends Controller
{
    public function placeBet(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'game_name' => 'required',
            'game_id' => 'required',
            'pana' => 'required|string',
            'date' => 'nullable|date_format:Y-m-d',
            'totalbet' => 'required',
            'bet' => 'required|array',
            'bet.*.session' => 'string',
            'bet.*.digits' => 'required|string',
            'bet.*.amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 401);
        }

        DB::beginTransaction();
        try {
            $user = User::findOrFail($user_id);

            if ($user->wallet_balance < $request->totalbet) {
                return response()->json(['error' => 'Insufficient wallet balance'], 400);
            }

            // Format the date to 'YYYY-MM-DD'
            $formattedDate = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');

            // Deduct wallet balance
            $user->wallet_balance -= $request->totalbet;
            $user->save();

            // Place the bet
            $bet = Bet::create([
                'user_id' => $user_id,
                'game_id' => $request->game_id,
                'game_name' => $request->game_name,
                'pana' => $request->pana,
                'date' => $formattedDate,  // Use the formatted date here
                'totalbet' => $request->totalbet,
                'bet' => json_encode($request->bet),
            ]);

            // Referral Bonus Logic
            $referringUserId = $user->referred_by; // Get the referring user ID
            if ($referringUserId) {
                $bonusAmount = $request->totalbet * 0.05;

                // Credit to the referred user's earn bonus
                DB::table('earn_bonus')->insert([
                    'user_id' => $user_id,
                    'referral_id' => $referringUserId,
                    'amount' => $bonusAmount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Credit to the referring user's earn bonus
                DB::table('earn_bonus')->insert([
                    'user_id' => $referringUserId,
                    'referral_id' => $user_id,
                    'amount' => $bonusAmount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Bet placed successfully with referral bonus credited',
                'data' => [
                    'game_name' => $request->game_name,
                    'pana' => $request->pana,
                    'date' => $formattedDate,  // Return the formatted date here
                    'totalbet' => $request->totalbet,
                    'game_id' => $request->game_id,
                    'bet' => $request->bet,
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'An error occurred while placing the bet.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getAllBets(Request $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            $bets = Bet::where('user_id', $user_id)->get();
            $response = $bets->map(function ($bet) {
                $betData = json_decode($bet->bet, true);
                return collect($betData)->map(function ($data) use ($bet) {
                    $session = $data['session'] ?? null;
                    $digits = $data['digits'] ?? null;
                    $amount = $data['amount'] ?? null;
                    return [
                        'session' => $session,
                        'digits' => $digits,
                        'amount' => $amount,
                        'game_name' => $bet->game_name ?? 'Unknown Game',
                        'pana' => $bet->pana,
                        'created_at' => Carbon::parse($bet->created_at)->format('Y-m-d H:i:s'),
                    ];
                });
            })->flatten(1);
            return response()->json([
                'bets' => $response,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching bets.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getTotalBetsCountUsers(Request $request, $user_id)
    {
        try {

            $user = User::findOrFail($user_id);

            $totalBetsCount = Bet::where('user_id', $user_id)->count();

            return response()->json([
                'message' => 'Total bets count retrieved successfully.',
                'total_bets_count' => $totalBetsCount
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the total bet count.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getTotalBetsCount(Request $request)
    {
        try {

            $totalBetsCount = Bet::count();

            return response()->json([
                'message' => 'Total bets count retrieved successfully.',
                'total_bets_count' => $totalBetsCount
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the total bet count.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function placeHalfSangamBet(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'game_name' => 'required',
            'game_id' => 'required', // Ensure game_id exists in the satta_matka_games table
            'pana' => 'required',
            'date' => 'required',
            'totalbet' => 'required',
            'bet' => 'required',
            'bet.*.session' => '',
            'bet.*.opendigit' => 'nullable',
            'bet.*.closedigit' => 'nullable',
            'bet.*.amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 401);
        }

        DB::beginTransaction();
        try {
            $user = User::findOrFail($user_id);

            if ($user->wallet_balance < $request->totalbet) {
                return response()->json(['error' => 'Insufficient wallet balance'], 400);
            }

            // Deduct wallet balance
            $user->wallet_balance -= $request->totalbet;
            $user->save();

            // Create the bet record
            $bet = HalfSangamBet::create([
                'user_id' => $user_id,
                'game_id' => $request->game_id,
                'game_name' => $request->game_name,
                'pana' => $request->pana,
                'date' => $request->date,
                'totalbet' => $request->totalbet,
                'bet' => json_encode($request->bet),
            ]);

            DB::commit();

            // Construct the response in the desired format
            return response()->json([
                'message' => 'Bet placed successfully',
                'data' => [
                    'game_name' => $bet->game_name,
                    'game_id' => $bet->game_id,
                    'pana' => $bet->pana,
                    'date' => $bet->date,
                    'totalbet' => $bet->totalbet,
                    'bet' => json_decode($bet->bet, true),
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'An error occurred while placing the bet.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getAllBetsForAllUsers(Request $request)
    {
        try {

            $bets = Bet::with(['user', 'game'])->get();

            $response = $bets->map(function ($bet) {
                $betData = json_decode($bet->bet, true);
                return collect($betData)->map(function ($data) use ($bet) {
                    $session = isset($data['session']) ? $data['session'] : null;
                    $digits = isset($data['digits']) ? $data['digits'] : null;
                    $amount = isset($data['amount']) ? $data['amount'] : null;
                    return [
                        'id' => $bet->id,
                        'user_id' => $bet->user_id,
                        'username' => optional($bet->user)->username,
                        'game_id' => $bet->game_id,
                        'game_name' => optional($bet->game)->game_name,
                        'session' => $session,
                        'digits' => $digits,
                        'amount' => $amount,
                        'pana' => $bet->pana,
                        'created_at' => Carbon::parse($bet->created_at)->format('Y-m-d H:i:s'),
                    ];
                });
            })->flatten(1);

            return response()->json([
                'bets' => $response
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching all bets.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getHalfSangamBetHistory(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'nullable|date',
            'game_id' => 'nullable|exists:satta_matka_games,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 401);
        }
        try {
            $query = HalfSangamBet::where('user_id', $user_id);

            if ($request->has('date')) {
                $query->whereDate('date', $request->date);
            }
            if ($request->has('game_id')) {
                $query->where('game_id', $request->game_id);
            }
            $bets = $query->get();

            $betsArray = $bets->map(function ($bet) {
                \Log::info('Processing bet:', ['bet' => $bet]);
                $betsData = json_decode($bet->bet, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    \Log::error('Invalid bet data', ['bet' => $bet->bet, 'error' => json_last_error_msg()]);
                    $betsData = [];
                }
                $formattedBets = !empty($betsData) ? $betsData[0] : [];
                $formattedCreatedAt = Carbon::parse($bet->created_at)->format('Y-m-d H:i:s');
                $user = User::find($bet->user_id);
                $game = SattaMatkaGame::find($bet->game_id);

                return [
                    'id' => $bet->id,
                    'user_id' => $bet->user_id,
                    'username' => $user ? $user->username : null,
                    'game_id' => $bet->game_id,
                    'game_name' => $bet->game_name,
                    'pana' => $bet->pana,
                    'session' => $formattedBets['session'] ?? null,
                    'opendigit' => $formattedBets['opendigit'] ?? null,
                    'closedigit' => $formattedBets['closedigit'] ?? null,
                    'amount' => $formattedBets['amount'] ?? null,
                    'created_at' => $formattedCreatedAt,
                ];
            });
            return response()->json([
                'bets' => $betsArray,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the bet history.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
