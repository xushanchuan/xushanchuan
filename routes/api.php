<?php

use App\Http\Controllers\HomeController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('activity/{id}',[HomeController::class, 'index']);
Route::post('activity',[HomeController::class, 'addActivity']);
Route::post('cache',[HomeController::class, 'cacheAdd']);
Route::get('cache',[HomeController::class, 'cacheGet']);
Route::get('config',[HomeController::class, 'getConfig']);
Route::get('storage',[HomeController::class, 'storage']);
Route::post('upload',[HomeController::class, 'upload']);
