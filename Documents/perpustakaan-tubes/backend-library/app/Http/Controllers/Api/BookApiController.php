<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookApiController extends Controller
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
        if ($request->filled('category_id')) {
            $q->where('category_id', $request->category_id);
        }

        return response()->json([
            'data' => $q->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'isbn' => ['nullable','string','max:50'],
            'title' => ['required','string','max:255'],
            'author' => ['nullable','string','max:255'],
            'publisher' => ['nullable','string','max:255'],
            'publication_year' => ['nullable','integer','min:1900','max:2100'],
            'stock' => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'cover_image' => ['nullable','string','max:255'],
        ]);

        $book = Book::create($data);
        return response()->json(['message' => 'Created', 'data' => $book], 201);
    }

    public function show(Book $book)
    {
        return response()->json(['data' => $book->load('category')]);
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'isbn' => ['nullable','string','max:50'],
            'title' => ['required','string','max:255'],
            'author' => ['nullable','string','max:255'],
            'publisher' => ['nullable','string','max:255'],
            'publication_year' => ['nullable','integer','min:1900','max:2100'],
            'stock' => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'cover_image' => ['nullable','string','max:255'],
        ]);

        $book->update($data);
        return response()->json(['message' => 'Updated', 'data' => $book]);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
