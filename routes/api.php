<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

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


Route::group(['prefix'=>'v1',], function() {
    Route::get('/docs', [APIController::class, 'index']);
    Route::get('/user', [APIController::class, 'user']);
    Route::get('/guru', [APIController::class, 'guru']);
    Route::get('/siswa', [APIController::class, 'siswa']);
    Route::get('/kegiatan', [APIController::class, 'kegiatan']);
    Route::get('/pelajaran', [APIController::class, 'pelajaran']);
});