<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index() {
        return response()->json(['data' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);
        $cat = Category::create($data);
        return response()->json(['message' => 'Created', 'data' => $cat], 201);
    }

    public function show(Category $category) {
        return response()->json(['data' => $category]);
    }

    public function update(Request $request, Category $category) {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);
        $category->update($data);
        return response()->json(['message' => 'Updated', 'data' => $category]);
    }

    public function destroy(Category $category) {
        $category->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
