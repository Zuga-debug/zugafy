<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\WatchlistController;


Route::get('/movie/{id}', [MovieController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/watchlist', [WatchlistController::class, 'index']);
    Route::post('/watchlist', [WatchlistController::class, 'store']);
    Route::delete('/watchlist/{movie_id}', [WatchlistController::class, 'destroy']);
});

// (Optional) Public test route
// Route::get('/ping', function () {
//     return response()->json(['message' => 'API working']);
// });

Route::get('/watchlist', [WatchlistController::class, 'index']);
Route::get('/watchlist/{id}', [WatchlistController::class, 'show']);
Route::post('/watchlist/{id}', [WatchlistController::class, 'store']);
Route::delete('/watchlist/{id}', [WatchlistController::class, 'destroy']);
