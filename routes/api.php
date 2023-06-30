<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CarController;
use App\Http\Controllers\api\RegistrationController;
use App\Http\Controllers\api\ReservationController;
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
Route::post('/registration', [RegistrationController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/cars',[CarController::class,'index']);
    Route::get('car/{car}/documents',[CarController::class,'getCarDocuments']);
    Route::get('/show-reservation/{user}',[ReservationController::class,'show']);
    Route::delete('/reservation/{reservation}/delete',[ReservationController::class,'destroy']);
    Route::post('/make-reservation', [ReservationController::class, 'store']);
    Route::put('/reservation/{reservation}/update',[ReservationController::class,'update']);
});

Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
    Route::post('/car/store', [CarController::class, 'store']);
    Route::post('/car/{car}/documents-store', [CarController::class, 'storeCarDocument']);
    Route::delete('/car/{car}/destroy', [CarController::class, 'destroy']);
    Route::delete('/car/{document}',[CarController::class,'destroyDocument']);
    Route::put('/car/{car}/update',[CarController::class,'update']);
    Route::get('/reservations',[ReservationController::class,'index']);
    Route::get('/reservations-export',[ReservationController::class,'export']);

});


