<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ParkingLevelController;
use App\Http\Controllers\Api\ParkingSpaceController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\ParkingEventController;
use App\Http\Controllers\Api\VehicleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Route::apiResource('parking-levels', ParkingLevelController::class);
// Route::apiResource('parking-spaces', ParkingSpaceController::class);
// Route::apiResource('devices', DeviceController::class);
// Route::apiResource('parking-events', ParkingEventController::class);
// Route::apiResource('vehicles', VehicleController::class);

Route::post('/parking-events', [ParkingEventController::class, 'store']);
Route::get('/parking/status', [ParkingSpaceController::class, 'getParkingStatus']);
Route::patch('/clear-parking-spaces', [ParkingSpaceController::class, 'clearAllParkingSpaces']);
Route::get('/vehicles', [VehicleController::class, 'getAllVehicles']);
Route::get('/parking-events', [ParkingEventController::class, 'index']);





