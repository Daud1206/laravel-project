<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // =============================
    // USER & ADMIN VIEW (SAME VIEW)
    // =============================
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query categories with search functionality
        $categories = Category::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%");
        })
            ->orderBy('id', 'DESC')
            ->paginate(10)
            ->appends(['search' => $search]);

        // Return the same 'categories.index' view for both user and admin
        return view('categories.index', compact('categories', 'search'));
    }

    // =============================
    // ADMIN CRUD
    // =============================
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted.');
    }
}
