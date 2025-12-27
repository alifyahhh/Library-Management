<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\Request;

class BorrowingApiController extends Controller
{
    public function index(Request $request)
    {
        $data = Borrowing::with(['book.category','fine'])
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function borrow(Request $request, Book $book)
    {
        if ($book->stock < 1) {
            return response()->json(['message' => 'Stock empty'], 400);
        }

        $borrowing = Borrowing::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
        ]);

        $book->decrement('stock');

        return response()->json(['message' => 'Borrowed', 'data' => $borrowing], 201);
    }

    public function return(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        if ($borrowing->status === 'returned') {
            return response()->json(['message' => 'Already returned'], 400);
        }

        $borrowing->return_date = now()->toDateString();

        // denda: 2000/hari
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

        return response()->json(['message' => 'Returned', 'data' => $borrowing->load('fine')]);
    }
}
