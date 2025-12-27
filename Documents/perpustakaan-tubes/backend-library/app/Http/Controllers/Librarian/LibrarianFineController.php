<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Fine;

class LibrarianFineController extends Controller
{
    public function index()
    {
        $fines = Fine::with(['borrowing.user','borrowing.book'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('librarian.fines.index', compact('fines'));
    }

    public function pay(Fine $fine)
    {
        $fine->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success','Fine marked as paid');
    }
}
