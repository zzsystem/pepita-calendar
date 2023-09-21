<?php

use App\Http\Controllers\BookedTimesController;
use App\Http\Controllers\OpeningHoursController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/opening-hours', OpeningHoursController::class);
Route::get('/booked-times', [BookedTimesController::class, 'index']);
Route::post('/booked-times', [BookedTimesController::class, 'save']);
