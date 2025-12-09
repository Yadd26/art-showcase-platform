<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // User statistics
        $stats = [
            'total_artworks' => $user->artworks()->count(),
            'total_likes' => $user->artworks()->sum('likes_count'),
            'total_comments' => $user->artworks()->sum('comments_count'),
            'total_favorites' => $user->artworks()->sum('favorites_count'),
            'total_submissions' => $user->submissions()->count(),
        ];
        
        // Recent artworks
        $recentArtworks = $user->artworks()
            ->with('category')
            ->latest()
            ->take(6)
            ->get();
        
        // Recent submissions
        $recentSubmissions = $user->submissions()
            ->with(['challenge', 'artwork'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('member.dashboard', compact(
            'stats',
            'recentArtworks',
            'recentSubmissions'
        ));
    }
    
    public function favorites()
    {
        $user = auth()->user();
        
        $favorites = $user->favorites()
            ->with(['artwork.user', 'artwork.category'])
            ->latest()
            ->paginate(12);
        
        return view('member.favorites', compact('favorites'));
    }
}