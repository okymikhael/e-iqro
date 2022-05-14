<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login', [RouterController::class, 'login'])->name('login');
Route::POST('/login', [LoginController::class, 'web_authenticate']);
Route::get('/logout', [RouterController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/', [RouterController::class, 'dashboard']); // dashboard
    Route::post('/meet_online', [RouterController::class, 'meet_online']); // add meet online link

    Route::get('/{route}', [RouterController::class, 'index']); // menu

    Route::get('/{route}/detail/{id}', [RouterController::class, 'show']); // show siswa
    Route::get('/{route}/detail/{id}/{table}', [RouterController::class, 'create_from_show']); // create nilai siswa
    Route::get('/{route}/detail/{id_from_show}/update-{table}/{id}', [RouterController::class, 'edit_from_show']); // update nilai siswa

    Route::get('/update-{route}/{id}', [RouterController::class, 'edit']); // update record menu
    Route::get('/{route}/{action}', [RouterController::class, 'create']); // create record menu
});