<?php

use App\Http\Controllers\RapidController;
use App\Http\Controllers\WatermarkController;
use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Route::post('/remove', [WatermarkController::class, 'remove'])->name('mark.run');
Route::post('/download', [WatermarkController::class, 'remove'])->name('mark.run');
Route::get('/download', function () {
    return view('download');
});
Route::post('/rapid', [RapidController::class, 'run'])->name('rapid.run');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
