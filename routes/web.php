<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouterController;

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

Route::get('/', function () {
    return view('pages/dashboard');
});

Route::get('/{route}', [RouterController::class, 'index']); // menu

Route::get('/{route}/detail/{id}', [RouterController::class, 'show']); // show siswa
Route::get('/{route}/detail/{id}/{table}', [RouterController::class, 'create_from_show']); // create nilai siswa
Route::get('/{route}/detail/{id_from_show}/update-{table}/{id}', [RouterController::class, 'edit_from_show']); // update nilai siswa

Route::get('/update-{route}/{id}', [RouterController::class, 'edit']); // update record menu
Route::get('/{route}/{action}', [RouterController::class, 'create']); // create record menu