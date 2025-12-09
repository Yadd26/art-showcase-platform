<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function index()
    {
        $artworks = auth()->user()->artworks()
            ->with('category')
            ->latest()
            ->paginate(12);
        
        return view('member.artworks.index', compact('artworks'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('member.artworks.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
            'tags' => 'nullable|string',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('artworks', $imageName, 'public');
            $validated['image_path'] = $imagePath;
        }
        
        // Process tags
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
            $validated['tags'] = $tags;
        }
        
        $validated['user_id'] = auth()->id();
        
        $artwork = Artwork::create($validated);
        
        return redirect()
            ->route('member.artworks.index')
            ->with('success', 'Artwork created successfully!');
    }
    
    public function show(Artwork $artwork)
    {
        // Ensure user owns this artwork
        if ($artwork->user_id !== auth()->id()) {
            abort(403);
        }
        
        $artwork->load(['category', 'comments.user']);
        
        return view('member.artworks.show', compact('artwork'));
    }
    
    public function edit(Artwork $artwork)
    {
        // Ensure user owns this artwork
        if ($artwork->user_id !== auth()->id()) {
            abort(403);
        }
        
        $categories = Category::all();
        
        return view('member.artworks.edit', compact('artwork', 'categories'));
    }
    
    public function update(Request $request, Artwork $artwork)
    {
        // Ensure user owns this artwork
        if ($artwork->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tags' => 'nullable|string',
        ]);
        
        // Handle image upload if new image provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($artwork->image_path) {
                Storage::disk('public')->delete($artwork->image_path);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('artworks', $imageName, 'public');
            $validated['image_path'] = $imagePath;
        }
        
        // Process tags
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
            $validated['tags'] = $tags;
        } else {
            $validated['tags'] = [];
        }
        
        $artwork->update($validated);
        
        return redirect()
            ->route('member.artworks.index')
            ->with('success', 'Artwork updated successfully!');
    }
    
    public function destroy(Artwork $artwork)
    {
        // Ensure user owns this artwork
        if ($artwork->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Delete image
        if ($artwork->image_path) {
            Storage::disk('public')->delete($artwork->image_path);
        }
        
        $artwork->delete();
        
        return redirect()
            ->route('member.artworks.index')
            ->with('success', 'Artwork deleted successfully!');
    }
}