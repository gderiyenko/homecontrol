<?php

use App\Http\Controllers\ObjectController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\HomeController;
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
    Route::get('/invites', [HomeController::class, 'invites']);
    Route::get('/runner', [HomeController::class, 'runner']);
});

Route::get('objects', [ObjectController::class, 'all']);
Route::prefix('object')->group(function () {
    Route::post('/', [ObjectController::class, 'store']);
    Route::put('/{object}', [ObjectController::class, 'update']);
    Route::delete('/{object}', [ObjectController::class, 'destroy']);
});

Route::get('commands', [CommandController::class, 'all']);
Route::prefix('command')->group(function () {
    Route::get('/{command}', [CommandController::class, 'run']);

    Route::post('/', [CommandController::class, 'store']);
    Route::put('/{command}', [CommandController::class, 'update']);
    Route::delete('/{command}', [CommandController::class, 'destroy']);
});

Route::get('invites', [InviteController::class, 'all']);
Route::prefix('invite')->group(function () {
    Route::post('/', [InviteController::class, 'store']);
    Route::put('/{invite}', [InviteController::class, 'update']);
    Route::delete('/{invite}', [InviteController::class, 'destroy']);
});
