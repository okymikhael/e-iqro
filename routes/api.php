<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\LoginController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('/login', [LoginController::class, 'authenticate']);

Route::group(['prefix'=>'v1', 'middleware' => ['auth:sanctum']], function() {
    Route::get('/docs', [APIController::class, 'index']);
    Route::get('/user', [APIController::class, 'user']);
    Route::get('/siswa', [APIController::class, 'siswa']);
    Route::get('/kegiatan', [APIController::class, 'kegiatan']);
    Route::get('/motorik', [APIController::class, 'motorik']);
    Route::get('/spider_chart', [APIController::class, 'spider_chart']);
    Route::get('/meet', [APIController::class, 'meet']);
});