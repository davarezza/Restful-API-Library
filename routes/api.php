<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\AuthorController;
use App\Http\Controllers\api\BookController;
use App\Http\Controllers\api\BorrowinDetailController;
use App\Http\Controllers\api\BorrowingController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PublisherController;
use App\Http\Controllers\api\ShelfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('library')->group(function() {
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function() {
        Route::get('books', [BookController::class, 'index']);
        Route::get('books/{book_id}', [BookController::class, 'show']);
        Route::get('shelves', [ShelfController::class, 'index']);
        Route::get('shelves/{shelf_id}', [ShelfController::class, 'show']);
        Route::get('publishers', [PublisherController::class, 'index']);
        Route::get('publishers/{publisher_id}', [PublisherController::class, 'show']);
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('categories/{category_id}', [CategoryController::class, 'show']);
        Route::get('authors', [AuthorController::class, 'index']);
        Route::get('authors/{author}', [AuthorController::class, 'show']);
        Route::apiResource('borrowings', BorrowingController::class);
        Route::apiResource('borrowing-detail', BorrowinDetailController::class);

        Route::middleware(['isAdmin'])->group(function() {
            Route::apiResource('books', BookController::class)->except(['index', 'show']);
            Route::match(['patch', 'post'], 'books/{book_id}', [BookController::class, 'update']);
            Route::apiResource('shelves', ShelfController::class)->except(['index', 'show']);
            Route::apiResource('publishers', PublisherController::class)->except(['index', 'show']);
            Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
            Route::apiResource('authors', AuthorController::class)->except(['index', 'show']);
        });
    });
});