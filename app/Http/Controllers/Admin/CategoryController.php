<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('tickets')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'default_priority' => 'required|in:low,medium,high,critical',
        ]);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'הקטגוריה נוצרה בהצלחה.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'default_priority' => 'required|in:low,medium,high,critical',
        ]);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'הקטגוריה עודכנה בהצלחה.');
    }

    public function destroy(Category $category)
    {
        if ($category->tickets()->exists()) {
            return back()->with('error', 'לא ניתן למחוק קטגוריה עם קריאות קיימות.');
        }

        $category->delete();

        return back()->with('success', 'הקטגוריה נמחקה.');
    }
}
