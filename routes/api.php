<?php

use App\Http\Controllers\BookingCustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HotelController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1/customers')->group(function () {
    Route::post('/', [CustomerController::class, 'create']);
    Route::post('/findAll', [CustomerController::class, 'findAll']);
    Route::get('/{id}', [CustomerController::class, 'getById']);
    Route::put('/{id}', [CustomerController::class, 'update']);
    Route::delete('/{id}', [CustomerController::class, 'delete']);
});

Route::prefix('v1/bookings')->group(function () {
    Route::post('/', [BookingController::class, 'create']);
    Route::post('/findAll', [BookingController::class, 'findAll']);
    Route::get('/{id}', [BookingController::class, 'getById']);
    Route::put('/{id}', [BookingController::class, 'update']);
    Route::delete('/{id}', [BookingController::class, 'delete']);
});

Route::prefix('v1/hotels')->group(function () {
    Route::post('/', [HotelController::class, 'create']);
    Route::post('/paginate', [HotelController::class, 'paginate']);
    Route::get('/list', [HotelController::class, 'list']);
    Route::get('/{id}', [HotelController::class, 'getById']);
    Route::put('/{id}', [HotelController::class, 'update']);
    Route::delete('/{id}', [HotelController::class, 'delete']);
});

Route::prefix('v1/customers')->group(function () {
    Route::post('/', [CustomerController::class, 'create']);
    Route::post('/findAll', [CustomerController::class, 'findAll']);
    Route::post('/searchByName', [CustomerController::class, 'searchByName']);
    Route::get('/{id}', [CustomerController::class, 'getById']);
    Route::put('/{id}', [CustomerController::class, 'update']);
    Route::delete('/{id}', [CustomerController::class, 'delete']);
});

Route::prefix('v1/booking-customer')->group(function () {
    Route::post('/', [BookingCustomerController::class, 'create']);
    Route::delete('/{booking_id}/{customer_id}', [BookingCustomerController::class, 'delete']);
});
