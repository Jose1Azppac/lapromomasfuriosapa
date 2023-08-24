<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class,'register']);

Route::get('user/{user}', [AuthController::class,'getUSer']);

Route::get('user/{user}/points/current', [ApiController::class,'userPointsCurrent']);
Route::get('user/{user}/points/global', [ApiController::class,'userPointsGlobal']);

Route::post('code', [ApiController::class,'useCode']);
