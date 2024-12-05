<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CacheClearController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/storage/{filename}', function ($filename) {
    $path = storage_path('app/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

Route::get('/clear-cache', [CacheClearController::class, 'clearCache']);
