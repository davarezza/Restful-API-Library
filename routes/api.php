<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\BorrowinDetailController;
use App\Http\Controllers\API\BorrowingController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PublisherController;
use App\Http\Controllers\API\ShelfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('library')->group(function() {
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:api')->group(function() {
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::apiResource('books', BookController::class);
        Route::apiResource('shelves', ShelfController::class);
        Route::apiResource('publishers', PublisherController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('authors', AuthorController::class);
        Route::apiResource('borrowings', BorrowingController::class);
    });
});