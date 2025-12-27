<?php
namespace App\Http\Controllers\Librarian;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\Fine;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        return view('librarian.dashboard', [
            'totalBooks' => Book::count(),
            'totalCategories' => Category::count(),
            'totalBorrowings' => Borrowing::count(),
            'unpaidFines' => Fine::where('status','unpaid')->count(),
        ]);
    }
}
