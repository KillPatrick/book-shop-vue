<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('books', BookController::class)->only(['index', 'show']);
Route::apiResource('reviews', ReviewController::class);

Route::middleware('auth:sanctum')->get('user_review', [\App\Http\Controllers\Api\V1\ReviewController::class, 'userReview']);
Route::middleware('auth:sanctum')->get('athenticated', function () {
    return true;
});
Route::post('login', [\App\Http\Controllers\Api\V1\LoginController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\Api\V1\LoginController::class, 'logout']);


