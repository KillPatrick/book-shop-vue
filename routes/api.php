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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('user_review', [\App\Http\Controllers\Api\V1\ReviewController::class, 'userReview']);
    Route::post('review/store', [\App\Http\Controllers\Api\V1\ReviewController::class, 'store']);
    Route::post('review/update/{review}', [\App\Http\Controllers\Api\V1\ReviewController::class, 'update']);
    Route::get('athenticated', function () {
        return true;
    });
    Route::get('user', [\App\Http\Controllers\Api\V1\UserController::class, 'index']);
    Route::group(['middleware' => 'auth.accessAdmin'], function(){
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
            Route::apiResource('books', \Admin\BookController::class);
        });
    });
});

Route::post('login', [\App\Http\Controllers\Api\V1\LoginController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\Api\V1\LoginController::class, 'logout']);
Route::post('register', [\App\Http\Controllers\Api\V1\RegisterController::class, 'register']);



