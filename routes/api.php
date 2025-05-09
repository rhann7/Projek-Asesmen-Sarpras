<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitItemController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReturningController;
use App\Http\Controllers\UsedItemController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/unit-items', [UnitItemController::class, 'index']);
   
   Route::post('/borrows', [BorrowingController::class, 'store']);
   Route::get('borrows/{id}', [BorrowingController::class, 'show']);
   Route::post('/returns', [ReturningController::class, 'store']);
   Route::get('returns/{id}', [ReturningController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('locations')->group(function () {
        Route::get('/', [LocationController::class, 'index']);
        Route::post('/', [LocationController::class, 'store']);
        Route::put('/{id}', [LocationController::class, 'update']);
        Route::delete('/{id}', [LocationController::class, 'destroy']);
    });

    Route::prefix('items')->group(function () {
        Route::get('/', [ItemController::class, 'index']);
        Route::post('/', [ItemController::class, 'store']);
        Route::put('/{id}', [ItemController::class, 'update']);
        Route::delete('/{id}', [ItemController::class, 'destroy']);
    });

    Route::prefix('unit-items')->group(function () {
        Route::get('/', [UnitItemController::class, 'index']);
        Route::post('/', [UnitItemController::class, 'store']);
        Route::put('/{id}', [UnitItemController::class, 'update']);
        Route::delete('/{id}', [UnitItemController::class, 'destroy']);
    });

    Route::prefix('borrows')->group(function () {
        Route::get('/', [BorrowingController::class, 'index']);
        Route::get('/{id}', [BorrowingController::class, 'show']);
        Route::put('/{id}', [BorrowingController::class, 'update']);
        Route::delete('/{id}', [BorrowingController::class, 'destroy']);
    });

    Route::prefix('returns')->group(function () {
        Route::get('/', [ReturningController::class, 'index']);
        Route::get('/{id}', [ReturningController::class, 'show']);
    });

    Route::prefix('used-items')->group(function () {
        Route::get('/', [UsedItemController::class, 'index']);
        Route::get('/{id}', [UsedItemController::class, 'show']);
        Route::put('/', [UsedItemController::class, 'store']);
        Route::delete('/{id}', [UsedItemController::class, 'destroy']);
    });
});