<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\BorrowingApiController;
use App\Http\Controllers\Api\FineApiController;

// publik: list + detail buku (biar search jalan walau belum login)
Route::get('/books', [BookApiController::class, 'index']);
Route::get('/books/{book}', [BookApiController::class, 'show']);

// auth
Route::post('/auth/register', [AuthApiController::class, 'register']);
Route::post('/auth/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthApiController::class, 'me']);
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);

    // librarian only sebaiknya (nanti bisa kita role-check)
    Route::apiResource('categories', CategoryApiController::class);
    Route::apiResource('books', BookApiController::class)->except(['index','show']);

    Route::get('/borrowings', [BorrowingApiController::class, 'index']);
    Route::post('/borrow/{book}', [BorrowingApiController::class, 'borrow']);
    Route::post('/return/{borrowing}', [BorrowingApiController::class, 'return']);

    Route::get('/my-fines', [FineApiController::class, 'myFines']);
    Route::post('/pay-fine/{fine}', [FineApiController::class, 'pay']);
});

