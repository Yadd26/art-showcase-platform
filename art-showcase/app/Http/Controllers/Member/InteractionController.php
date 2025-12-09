<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Favorite;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Enums\ReportStatus;

class InteractionController extends Controller
{
    public function like(Artwork $artwork)
    {
        $user = auth()->user();
        
        $existingLike = Like::where('user_id', $user->id)
            ->where('artwork_id', $artwork->id)
            ->first();
        
        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $artwork->decrementLikesCount();
            $message = 'Artwork unliked';
            $liked = false;
        } else {
            // Like
            Like::create([
                'user_id' => $user->id,
                'artwork_id' => $artwork->id,
            ]);
            $artwork->incrementLikesCount();
            $message = 'Artwork liked';
            $liked = true;
        }
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'liked' => $liked,
                'likes_count' => $artwork->fresh()->likes_count,
            ]);
        }
        
        return back()->with('success', $message);
    }
    
    public function favorite(Artwork $artwork)
    {
        $user = auth()->user();
        
        $existingFavorite = Favorite::where('user_id', $user->id)
            ->where('artwork_id', $artwork->id)
            ->first();
        
        if ($existingFavorite) {
            // Remove from favorites
            $existingFavorite->delete();
            $artwork->decrementFavoritesCount();
            $message = 'Removed from favorites';
            $favorited = false;
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => $user->id,
                'artwork_id' => $artwork->id,
            ]);
            $artwork->incrementFavoritesCount();
            $message = 'Added to favorites';
            $favorited = true;
        }
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'favorited' => $favorited,
                'favorites_count' => $artwork->fresh()->favorites_count,
            ]);
        }
        
        return back()->with('success', $message);
    }
    
    public function comment(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'artwork_id' => $artwork->id,
            'content' => $validated['content'],
        ]);
        
        $artwork->incrementCommentsCount();
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'comment' => $comment->load('user'),
            ]);
        }
        
        return back()->with('success', 'Comment added successfully');
    }
    
    public function deleteComment(Comment $comment)
    {
        // Ensure user owns this comment
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }
        
        $artwork = $comment->artwork;
        $comment->delete();
        $artwork->decrementCommentsCount();
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully',
            ]);
        }
        
        return back()->with('success', 'Comment deleted successfully');
    }
    
    public function report(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:SARA,Plagiat,Konten Tidak Pantas,Spam,Lainnya',
            'description' => 'nullable|string|max:500',
        ]);
        
        // Check if user already reported this artwork
        $existingReport = Report::where('reporter_id', auth()->id())
            ->where('artwork_id', $artwork->id)
            ->where('status', ReportStatus::PENDING)
            ->first();
        
        if ($existingReport) {
            return back()->with('error', 'You have already reported this artwork');
        }
        
        Report::create([
            'reporter_id' => auth()->id(),
            'artwork_id' => $artwork->id,
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? null,
            'status' => ReportStatus::PENDING,
        ]);
        
        return back()->with('success', 'Report submitted successfully. Our team will review it.');
    }
    
    public function reportComment(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:SARA,Spam,Konten Tidak Pantas,Lainnya',
            'description' => 'nullable|string|max:500',
        ]);
        
        // Check if user already reported this comment
        $existingReport = Report::where('reporter_id', auth()->id())
            ->where('comment_id', $comment->id)
            ->where('status', ReportStatus::PENDING)
            ->first();
        
        if ($existingReport) {
            return back()->with('error', 'You have already reported this comment');
        }
        
        Report::create([
            'reporter_id' => auth()->id(),
            'comment_id' => $comment->id,
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? null,
            'status' => ReportStatus::PENDING,
        ]);
        
        return back()->with('success', 'Report submitted successfully. Our team will review it.');
    }
}