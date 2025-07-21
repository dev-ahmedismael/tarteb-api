<?php

    use App\Http\Controllers\ConsultationController;
    use App\Http\Controllers\ServiceController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

    Route::post('login', [UserController::class, 'login']);

    // Consultations
    Route::apiResource('consultations', ConsultationController::class)->only('store');

    // Services
    Route::apiResource('services', ServiceController::class)->only('index');

    // PROTECTED ROUTES


    Route::middleware('auth:api')->group(function () {
        // Users
        Route::get('me', [UserController::class, 'me']);
        Route::put('user', [UserController::class, 'update']);
        Route::post('change-password', [UserController::class, 'change_password']);
        Route::get('logout', [UserController::class, 'logout']);

        // Consultations
        Route::apiResource('consultations', ConsultationController::class)
            ->except('store');

        // Services
        Route::apiResource('services', ServiceController::class)->except('index');


    });
