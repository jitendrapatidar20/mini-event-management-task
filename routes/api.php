<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login',    [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Authentication & Role Check Required)
|--------------------------------------------------------------------------
| These routes require the user to be logged in via Sanctum
| and have a role_id of 3 (checked by role.check middleware).
*/



Route::group(['middleware' => ['auth:sanctum']], function() {

   // Authentication
    Route::post('/auth/logout', fn(Request $request) => app(AuthController::class)->logout($request));
    Route::get('/details/user', fn(Request $request) => $request->user());

    // Booking Endpoints
    Route::get('/booking/events-list',   [BookingController::class, 'listEvents']);
    Route::post('/booking/book-event',   [BookingController::class, 'bookEvent']);
    Route::get('/booking/my-bookings',   [BookingController::class, 'myBookings']);
});
