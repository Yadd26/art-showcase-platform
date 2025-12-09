<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $query = Artwork::with(['user', 'category']);
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('display_name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'popular':
                $query->popular();
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
        }
        
        $artworks = $query->paginate(12);
        
        return view('guest.artworks.index', compact('artworks', 'categories'));
    }
    
    public function show(Artwork $artwork)
    {
        $artwork->load(['user', 'category', 'comments.user']);
        
        // Related artworks (same category)
        $relatedArtworks = Artwork::with(['user', 'category'])
            ->where('category_id', $artwork->category_id)
            ->where('id', '!=', $artwork->id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        // Check if user has liked/favorited (if authenticated)
        $hasLiked = false;
        $hasFavorited = false;
        
        if (auth()->check()) {
            $hasLiked = auth()->user()->hasLiked($artwork);
            $hasFavorited = auth()->user()->hasFavorited($artwork);
        }
        
        return view('guest.artworks.show', compact(
            'artwork',
            'relatedArtworks',
            'hasLiked',
            'hasFavorited'
        ));
    }
    
    public function profile(User $user)
    {
        // Only show approved members or curators
        if (!$user->isApproved()) {
            abort(404);
        }
        
        $artworks = Artwork::with(['category'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);
        
        $stats = [
            'total_artworks' => $user->artworks()->count(),
            'total_likes' => $user->artworks()->sum('likes_count'),
            'total_comments' => $user->artworks()->sum('comments_count'),
        ];
        
        return view('guest.profile', compact('user', 'artworks', 'stats'));
    }
}