<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Review\ReviewController;
use App\Http\Middleware\EnsureTokenIsValid;

Route::prefix('reviews')->group(function () {
  Route::get('/', [ReviewController::class, 'index']);
  Route::post('/', [ReviewController::class, 'store']);
  Route::get('/{id}', [ReviewController::class, 'show']);
  Route::put('/{id}', [ReviewController::class, 'update']);
  Route::delete('/{id}', [ReviewController::class, 'destroy']);
  Route::post('/import', [ReviewController::class, 'import']);
})->middleware(EnsureTokenIsValid::class);;