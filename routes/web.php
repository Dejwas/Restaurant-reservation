<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', fn () => to_route('reservations.create'));

Route::get('login', fn () => to_route('auth.create'))->name('login');
Route::get('admin', fn () => to_route('auth.create'))->name('admin');
Route::resource('auth', AuthController::class)
    ->only(['create', 'store']);

Route::delete('auth', [AuthController::class, 'destroy'])
    ->name('auth.destroy');

Route::resource('reservations', ReservationController::class);

Route::middleware('auth')->group(function() {
    Route::resource('restaurants', RestaurantController::class);
});