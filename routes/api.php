<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\ComplaintController;
use App\Http\Controllers\API\NewsCategoryController;
use App\Http\Controllers\API\ComplaintCategoryController;
use Symfony\Component\HttpFoundation\Response;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api',)->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('news', NewsController::class);
    Route::apiResource('news-category', NewsCategoryController::class);
    Route::apiResource('complaint', ComplaintController::class);
    Route::apiResource('complaint-category', ComplaintCategoryController::class);
});

// tolak semua request selain yang diatas
Route::fallback(function () {
    return response()->json([
        'message' => 'Resource Not Found. If error persists, contact',
        'status' => 404,
    ], Response::HTTP_NOT_FOUND);
});