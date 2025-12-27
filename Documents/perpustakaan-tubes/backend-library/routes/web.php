<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Librarian\LibrarianDashboardController;
use App\Http\Controllers\Librarian\LibrarianBookController;
use App\Http\Controllers\Librarian\LibrarianCategoryController;
use App\Http\Controllers\Librarian\LibrarianBorrowingController;
use App\Http\Controllers\Librarian\LibrarianFineController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});

// Group khusus librarian
Route::prefix('librarian')
    ->name('librarian.')
    ->middleware(['auth', 'librarian'])
    ->group(function () {
        Route::get('/', [LibrarianDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', LibrarianCategoryController::class)->except(['show']);
        Route::resource('books', LibrarianBookController::class)->except(['show']);
        Route::get('borrowings', [LibrarianBorrowingController::class, 'index'])->name('borrowings.index');
        Route::post('borrowings/{borrowing}/return', [LibrarianBorrowingController::class, 'forceReturn'])->name('borrowings.return');

        Route::get('fines', [LibrarianFineController::class, 'index'])->name('fines.index');
        Route::post('fines/{fine}/pay', [LibrarianFineController::class, 'pay'])->name('fines.pay');
    });

require __DIR__.'/auth.php';
