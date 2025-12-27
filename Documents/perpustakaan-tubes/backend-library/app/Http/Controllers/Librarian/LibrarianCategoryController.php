<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class LibrarianCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        return view('librarian.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('librarian.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        Category::create($data);
        return redirect()->route('librarian.categories.index')->with('success','Category created');
    }

    public function edit(Category $category)
    {
        return view('librarian.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $category->update($data);
        return redirect()->route('librarian.categories.index')->with('success','Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','Category deleted');
    }
}
