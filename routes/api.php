<?php

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

Route::post('activity', [\App\Http\Controllers\Api\ActivityController::class, 'index'])->name('activity.index');
Route::get('activity/{id}', [\App\Http\Controllers\Api\ActivityController::class, 'show'])->name('activity.show');
Route::post('activity/{id}/reservation', [\App\Http\Controllers\Api\ActivityReservationController::class, 'store'])->name('activity_reservation.store');
