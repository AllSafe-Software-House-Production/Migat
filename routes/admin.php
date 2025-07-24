<?php

use App\Http\Controllers\Admin\AirportTransferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ReligiousTourController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\SponsorController;

Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'role:admin', 'check.permission'])->group(function () {
        Route::get('dashboard', function () {
            return response()->json(['message' => 'Welcome Admin']);
        });

        Route::apiResource('roles', RoleController::class);
        Route::apiResource('rules', RuleController::class);
        Route::apiResource('hotels', HotelController::class);
        Route::apiResource('reviews', ReviewController::class);
        Route::apiResource('rooms', RoomController::class);
        Route::apiResource('reservations', ReservationController::class);
        Route::apiResource('packages', PackageController::class);
        Route::apiResource('tours', ReligiousTourController::class);
        Route::apiResource('airport-transfers', AirportTransferController::class);
        Route::apiResource('sponsors', SponsorController::class);
        Route::apiResource('faqs', FaqController::class);
        Route::apiResource('requests', RequestController::class);



        Route::post('logout', [AuthController::class, 'logout']);
    });
});
