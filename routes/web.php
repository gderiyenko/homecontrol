<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObjectController;
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
    return view('welcome');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::prefix('home')->group(function () {
    Route::get('/', function () { return view('welcome'); });
    Route::get('/objects', [HomeController::class, 'objects']);
    Route::get('/commands', [HomeController::class, 'commands']);
    Route::get('/teams', [HomeController::class, 'teams']);
});

Route::get('objects', [ObjectController::class, 'all']);
Route::prefix('object')->group(function () {
    Route::get('/{object}', [ObjectController::class, 'show']);
    Route::post('/', [ObjectController::class, 'store']);
    Route::put('/', [ObjectController::class, 'update']);
    Route::delete('/', [ObjectController::class, 'destroy']);
});

Route::get('commands', [ObjectController::class, 'all']);
Route::prefix('command')->group(function () {
    Route::get('/', [ObjectController::class, 'show']);
    Route::post('/', [ObjectController::class, 'store']);
    Route::put('/', [ObjectController::class, 'update']);
    Route::delete('/', [ObjectController::class, 'destroy']);
});

Route::get('teams', [ObjectController::class, 'all']);
Route::prefix('team')->group(function () {
    Route::get('/', [ObjectController::class, 'show']);
    Route::post('/', [ObjectController::class, 'store']);
    Route::put('/', [ObjectController::class, 'update']);
    Route::delete('/', [ObjectController::class, 'destroy']);
});
