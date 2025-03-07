<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Review\ReviewController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::prefix('v1')->group(function () {
  Route::prefix('reviews')->group(function () {
      Route::get('/', [ReviewController::class, 'index']);
      Route::post('/', [ReviewController::class, 'store']);
      Route::get('/{id}', [ReviewController::class, 'show']);
      Route::put('/{id}', [ReviewController::class, 'update']);
      Route::delete('/{id}', [ReviewController::class, 'destroy']);
      Route::post('/import', [ReviewController::class, 'import']);
  })->middleware(EnsureTokenIsValid::class);

  Route::get('user', [AuthController::class, 'user']);
  Route::post('register', [AuthController::class, 'register']);
})->middleware('auth:sanctum');