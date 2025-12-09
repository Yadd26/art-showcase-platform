<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index(Request $request)
    {
        $query = Challenge::with('curator');
        
        // Filter by status
        $status = $request->get('status', 'active');
        
        switch ($status) {
            case 'upcoming':
                $query->upcoming();
                break;
            case 'ended':
                $query->ended();
                break;
            default:
                $query->active();
        }
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $challenges = $query->latest()->paginate(9);
        
        return view('guest.challenges.index', compact('challenges', 'status'));
    }
    
    public function show(Challenge $challenge)
    {
        $challenge->load(['curator', 'submissions.artwork.user']);
        
        // Get submissions with winners first
        $submissions = $challenge->submissions()
            ->with(['artwork.user', 'artwork.category'])
            ->orderByRaw('winner_rank IS NULL')
            ->orderBy('winner_rank')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get winners
        $winners = $challenge->winners()->with(['artwork.user'])->get();
        
        // Check if user has submitted (if authenticated)
        $hasSubmitted = false;
        $userSubmission = null;
        
        if (auth()->check()) {
            $userSubmission = $challenge->submissions()
                ->where('user_id', auth()->id())
                ->first();
            $hasSubmitted = !is_null($userSubmission);
        }
        
        return view('guest.challenges.show', compact(
            'challenge',
            'submissions',
            'winners',
            'hasSubmitted',
            'userSubmission'
        ));
    }
}