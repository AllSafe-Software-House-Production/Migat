<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\ReligiousTourController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::get('hotels', [HotelController::class, 'index']);
Route::get('services', [HotelController::class, 'services']);
Route::get('reviews/hotel/{hotel}', [HotelController::class, 'hotelReviews']);
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('packages', [PackageController::class, 'index']);
Route::get('/religious-tours', [ReligiousTourController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [UserProfileController::class, 'show']);
    Route::put('profile', [UserProfileController::class, 'update']);

    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('reservation-form', [ReservationController::class, 'store']);

    Route::post('/airport-transfer-form', [RequestController::class, 'storeAirportTransfer']);

    Route::post('/religious-tours-form', [ReligiousTourController::class, 'storeTour']);

    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/toggle/{hotelId}', [FavoriteController::class, 'toggle']);

    Route::post('reviews', [ReviewController::class, 'store']);
    Route::post('logout', [AuthController::class, 'logout']);
});

    Route::get('/run-migrations', function (Request $request) {
        $key = $request->query('key');

        if ($key !== 'hhhlol') {
            abort(403);
        }

        Artisan::call('migrate', ['--force' => true]);
        return 'Migration done.';
    });

    Route::get('/run-seeder', function (Request $request) {
        $key = $request->query('key');

        if ($key !== 'hhhlol') {
            abort(403, 'Unauthorized');
        }

        Artisan::call('db:seed', [
            '--class' => 'AdminPermissionsSeeder',
            '--force' => true,
        ]);

        return 'Seeding done.';
    });

    Route::get('/create-storage-link', function (Request $request) {
        $key = $request->query('key');

        if ($key !== 'hhhlol') {
            abort(403, 'Unauthorized');
        }

        if (File::exists(public_path('storage'))) {
            return 'Symlink already exists.';
        }

        try {
            Artisan::call('storage:link');
            return 'Storage symlink created.';
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Could not create symlink',
                'message' => $e->getMessage(),
            ], 500);
        }
    });