<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Challenge;
use App\Models\Artwork;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = auth()->user()->submissions()
            ->with(['challenge', 'artwork.category'])
            ->latest()
            ->paginate(12);
        
        return view('member.submissions', compact('submissions'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'challenge_id' => 'required|exists:challenges,id',
            'artwork_id' => 'required|exists:artworks,id',
        ]);
        
        $challenge = Challenge::findOrFail($validated['challenge_id']);
        
        // Check if challenge is still active
        if (!$challenge->canSubmit()) {
            return back()->with('error', 'This challenge is no longer accepting submissions.');
        }
        
        // Check if artwork belongs to user
        $artwork = auth()->user()->artworks()->findOrFail($validated['artwork_id']);
        
        // Check if already submitted
        $existing = Submission::where('challenge_id', $challenge->id)
            ->where('artwork_id', $artwork->id)
            ->first();
        
        if ($existing) {
            return back()->with('error', 'This artwork has already been submitted to this challenge.');
        }
        
        // Check if user already submitted to this challenge
        $userSubmission = Submission::where('challenge_id', $challenge->id)
            ->where('user_id', auth()->id())
            ->first();
        
        if ($userSubmission) {
            return back()->with('error', 'You have already submitted an artwork to this challenge.');
        }
        
        Submission::create([
            'challenge_id' => $challenge->id,
            'artwork_id' => $artwork->id,
            'user_id' => auth()->id(),
        ]);
        
        return back()->with('success', 'Artwork submitted successfully to the challenge!');
    }
    
    public function destroy(Submission $submission)
    {
        // Ensure user owns this submission
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Cannot delete if already a winner
        if ($submission->isWinner()) {
            return back()->with('error', 'Cannot delete a winning submission.');
        }
        
        $submission->delete();
        
        return back()->with('success', 'Submission removed successfully.');
    }
}