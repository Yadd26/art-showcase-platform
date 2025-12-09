<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Challenge;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Featured artworks (high likes)
        $featuredArtworks = Artwork::with(['user', 'category'])
            ->where('likes_count', '>', 5)
            ->latest()
            ->take(6)
            ->get();
        
        // Popular artworks
        $popularArtworks = Artwork::with(['user', 'category'])
            ->popular()
            ->take(8)
            ->get();
        
        // Recent artworks
        $recentArtworks = Artwork::with(['user', 'category'])
            ->recent()
            ->take(12)
            ->get();
        
        // Active challenges
        $activeChallenges = Challenge::with('curator')
            ->active()
            ->take(4)
            ->get();
        
        // Filter by category if requested
        if ($request->has('category')) {
            $recentArtworks = Artwork::with(['user', 'category'])
                ->byCategory($request->category)
                ->recent()
                ->take(12)
                ->get();
        }
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $recentArtworks = Artwork::with(['user', 'category'])
                ->where('title', 'like', "%{$search}%")
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->recent()
                ->paginate(12);
        }
        
        return view('guest.home', compact(
            'featuredArtworks',
            'popularArtworks',
            'recentArtworks',
            'activeChallenges',
            'categories'
        ));
    }
}