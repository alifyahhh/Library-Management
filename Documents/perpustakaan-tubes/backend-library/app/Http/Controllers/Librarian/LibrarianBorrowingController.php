<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\Request;

class LibrarianBorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user','book.category','fine'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('librarian.borrowings.index', compact('borrowings'));
    }

    public function forceReturn(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Already returned');
        }

        $borrowing->return_date = now()->toDateString();

        if (now()->gt($borrowing->due_date)) {
            $daysLate = now()->diffInDays($borrowing->due_date);
            $amount = $daysLate * 2000;

            $borrowing->status = 'overdue';

            Fine::firstOrCreate(
                ['borrowing_id' => $borrowing->id],
                ['amount' => $amount, 'status' => 'unpaid']
            );
        } else {
            $borrowing->status = 'returned';
        }

        $borrowing->save();
        $borrowing->book()->increment('stock');

        return back()->with('success', 'Return processed');
    }
}
