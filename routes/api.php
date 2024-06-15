<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('library')->group(function() {
    Route::post('login', [AuthController::class, 'login']);
});