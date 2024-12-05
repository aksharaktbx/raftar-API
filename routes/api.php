<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GameChatController;
use App\Http\Controllers\AddFundController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\SattaMatkaGameController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HowToPlayVideoController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\GameRateController;
use App\Http\Controllers\GamechartController;
use App\Http\Controllers\GameResultController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\PaymentScreenshotController;
use App\Http\Controllers\WinHistoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('send-otp', [OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpController::class, 'verifyOTP']);
Route::get('/users', [RegisterController::class, 'getAllUsers']);
Route::get('/users/{id}', [RegisterController::class, 'getUserById']);
Route::put('/user/{id}', [RegisterController::class, 'updateUser']);
Route::put('/users/mpin/{id}', [RegisterController::class, 'updateMpin']);
Route::post('/users/notifications/{user_id}', [NotificationController::class, 'createNotification']);
Route::get('/users/notifications/{user_id}', [NotificationController::class, 'getNotifications']);
Route::post('/users/game-chats/{user_id}', [GameChatController::class, 'sendMessage']);
Route::get('/users/game-chats/{user_id}', [GameChatController::class, 'getMessages']);
Route::post('add-fund/{user_id}', [AddFundController::class, 'addFund']);
Route::post('withdraw/{userId}', [WithdrawalController::class, 'withdraw']);
Route::get('user/wallet-balance/{id}', [RegisterController::class, 'getWalletBalance']);
Route::post('/sattamatka/game', [SattaMatkaGameController::class, 'store']);
Route::delete('/games/{id}', [SattaMatkaGameController::class, 'destroy']);
Route::put('/games/{id}', [SattaMatkaGameController::class, 'update']);
Route::get('/games/{user_id}', [SattaMatkaGameController::class, 'index']);
Route::get('/games', [SattaMatkaGameController::class, 'getgamelist']);
Route::post('/how-to-play-video', [HowToPlayVideoController::class, 'store']);
Route::get('/how-to-play-video', [HowToPlayVideoController::class, 'show']);
Route::post('/user/verify-mpin/{id}', [RegisterController::class, 'verifyMpin']);
Route::get('/transaction-history/{userId}', [TransactionHistoryController::class, 'getTransactionHistory']);
Route::get('/transaction-history', [TransactionHistoryController::class, 'index']);
Route::post('/bets/{user_id}', [BetController::class, 'placeBet']);
Route::post('/half-sangam-bets/{user_id}', [BetController::class, 'placeHalfSangamBet']);
Route::get('referral-details/{user_id}', [ReferralController::class, 'getReferralDetails']);
Route::post('payment-screenshot', [PaymentScreenshotController::class, 'store']);
Route::get('payment-screenshots', [PaymentScreenshotController::class, 'index']);
Route::get('/results', [GameResultController::class, 'getResults']);
Route::delete('payment-screenshots/{id}', [PaymentScreenshotController::class, 'destroy']);
Route::get('/user-count', [RegisterController::class, 'getTotalUserCount']);
Route::post('/forgot-password', [ForgetController::class, 'sendOtp']);
Route::post('/verify-otp', [ForgetController::class, 'verifyOtp']);
Route::post('check-email', [ForgetController::class, 'checkEmail']);  
Route::post('reset-password', [ForgetController::class, 'resetPassword']);  
Route::post('forgot-mpin', [RegisterController::class, 'sendMpinOtp']);
Route::post('reset-mpin', [RegisterController::class, 'resetMpin']);
Route::delete('/user/{id}', [RegisterController::class, 'deleteUser']);
Route::put('/users/status/{id}', [RegisterController::class, 'toggleUserStatus']);
Route::post('/users/{user_id}/place-bet', [BetController::class, 'placeBet']);
Route::get('/users/bets/{user_id}', [BetController::class, 'getAllBets']);
Route::get('/users/{user_id}/total-bets-count', [BetController::class, 'getTotalBetsCountUsers']);
Route::get('/total-bets-count', [BetController::class, 'getTotalBetsCount']);
Route::get('/total-games-count', [SattaMatkaGameController::class, 'getTotalGamesCount']);
Route::get('/total-deposit-count', [AddFundController::class, 'getTotalDepositAmount']);
Route::get('/total-withdraw-amount', [WithdrawalController::class, 'getTotalWithdrawAmount']);
Route::delete('/delete-withdrawl', [WithdrawalController::class, 'deleteAllWithdrawals']);
Route::get('/bets/all', [BetController::class, 'getAllBetsForAllUsers']);
Route::get('/getHalfSangamBetHistory/{user_id}', [BetController::class, 'getHalfSangamBetHistory']);
Route::get('game-charts', [GamechartController::class, 'index']);
Route::get('game-charts', [GamechartController::class, 'index']);
Route::post('game-charts', [GamechartController::class, 'store']);
Route::get('game-charts/{id}', [GamechartController::class, 'show']);
Route::put('game-charts/{id}', [GamechartController::class, 'update']);
Route::delete('game-charts/{id}', [GamechartController::class, 'destroy']);
Route::post('/user/{id}/join-referral', [ReferralController::class, 'joinReferral']);
Route::get('/win-histories', [WinHistoryController::class, 'index']);
Route::post('/win-histories/{user_id}', [WinHistoryController::class, 'store']);
Route::delete('/win-histories/{id}', [WinHistoryController::class, 'destroy']);
Route::patch('/add-fund/approve/{addFundId}', [AddFundController::class, 'approveFund']);
Route::patch('/add-fund/disapprove/{addFundId}', [AddFundController::class, 'disapproveFund']);
Route::delete('/users/{id}/wallet-balance', [RegisterController::class, 'deleteWalletBalance']);
Route::get('/fund-requests', [AddFundController::class, 'getAllFundRequests']);
Route::post('/verify-otp', [RegisterController::class, 'verifyOTP']);
Route::post('/verify-otp', [RegisterController::class, 'verifyOTP']);
Route::delete('/add-fund/{id}', [AddFundController::class, 'deleteFund'])->name('delete-fund');
Route::prefix('game-rates')->group(function () {
    Route::post('/', [GameRateController::class, 'store']);
    Route::get('/', [GameRateController::class, 'index']);
    Route::get('{id}', [GameRateController::class, 'show']);
    Route::put('{id}', [GameRateController::class, 'update']);
    Route::delete('{id}', [GameRateController::class, 'destroy']);
});
Route::prefix('contact-us')->group(function () {
    Route::post('/', [ContactUsController::class, 'store']);
    Route::get('/', [ContactUsController::class, 'index']);
    Route::get('/{id}', [ContactUsController::class, 'edit']);
    Route::put('/{id}', [ContactUsController::class, 'update']);
    Route::delete('/{id}', [ContactUsController::class, 'destroy']);
});
Route::post('/game-results', [GameResultController::class, 'store']);
Route::get('/game-results', [GameResultController::class, 'index']);
Route::post('check-mpin-email', [ForgetController::class, 'checkmpinEmail']);
Route::post('reset-mpin', [ForgetController::class, 'resetMPIN']);