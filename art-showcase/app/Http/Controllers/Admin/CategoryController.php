<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('artworks')
            ->latest()
            ->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:10',
        ]);
        
        Category::create($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:10',
        ]);
        
        $category->update($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }
    
    public function destroy(Category $category)
    {
        $artworksCount = $category->artworks()->count();
        
        if ($artworksCount > 0) {
            return back()->with('error', "Cannot delete category '{$category->name}' because it has {$artworksCount} artworks.");
        }
        
        $categoryName = $category->name;
        $category->delete();
        
        return back()->with('success', "Category '{$categoryName}' has been deleted successfully.");
    }
}