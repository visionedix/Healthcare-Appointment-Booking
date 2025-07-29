<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HealthCareProfessionalController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {
    
    Route::group(['prefix' => 'professional', 'name' => 'professional.'], function () {
        Route::get('/', [HealthCareProfessionalController::class, 'index'])->name('all');
        Route::get('/{id}', [HealthCareProfessionalController::class, 'show'])->name('byId');
    });

    Route::group(['prefix' => 'appointment', 'name' => 'appointment.'], function () {
        Route::get('/', [AppointmentController::class, 'userAppointments'])->name('userAppointments');
        Route::post('/', [AppointmentController::class, 'book'])->name('book');
        Route::post('/{id}/complete', [AppointmentController::class, 'markComplete'])->name('markComplete');
        Route::delete('/{id}', [AppointmentController::class, 'cancel'])->name('cancel');
    });
    
   Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});