<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class LibrarianBookController extends Controller
{
    public function index(Request $request)
    {
        $q = Book::with('category')->orderByDesc('id');

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $q->where(function($w) use ($kw) {
                $w->where('title','like',"%$kw%")
                  ->orWhere('author','like',"%$kw%")
                  ->orWhere('isbn','like',"%$kw%");
            });
        }

        $books = $q->paginate(10)->withQueryString();
        return view('librarian.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('librarian.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'isbn' => ['nullable','string','max:50'],
            'title' => ['required','string','max:255'],
            'author' => ['nullable','string','max:255'],
            'stock' => ['required','integer','min:0'],
        ]);

        Book::create($data);
        return redirect()->route('librarian.books.index')->with('success','Book created');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('librarian.books.edit', compact('book','categories'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'isbn' => ['nullable','string','max:50'],
            'title' => ['required','string','max:255'],
            'author' => ['nullable','string','max:255'],
            'stock' => ['required','integer','min:0'],
        ]);

        $book->update($data);
        return redirect()->route('librarian.books.index')->with('success','Book updated');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success','Book deleted');
    }
}

