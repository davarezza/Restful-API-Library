<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\AuthorController;
use App\Http\Controllers\api\BookController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PublisherController;
use App\Http\Controllers\api\ShelfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('library')->group(function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('books', BookController::class)->except(['update']);
        Route::match(['patch', 'post'], 'books/{book_id}', [BookController::class, 'update']);
        // Route::patch('books/{book}', [BookController::class, 'update']);
        Route::apiResource('shelves', ShelfController::class);
        Route::apiResource('publishers', PublisherController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('authors', AuthorController::class);
    });
});