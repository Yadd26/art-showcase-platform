<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Submission;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    public function index(Challenge $challenge)
    {
        // Ensure curator owns this challenge
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if challenge has ended
        if (!$challenge->canSelectWinners()) {
            return redirect()->route('curator.challenges.show', $challenge)
                ->with('error', 'Challenge must be ended before selecting winners.');
        }
        
        $submissions = $challenge->submissions()
            ->with(['artwork.user', 'artwork.category'])
            ->get();
        
        $currentWinners = $challenge->winners()->with(['artwork.user'])->get();
        
        return view('curator.challenges.winners', compact('challenge', 'submissions', 'currentWinners'));
    }
    
    public function store(Request $request, Challenge $challenge)
    {
        // Ensure curator owns this challenge
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'first_place' => 'required|exists:submissions,id',
            'second_place' => 'nullable|exists:submissions,id|different:first_place',
            'third_place' => 'nullable|exists:submissions,id|different:first_place,second_place',
        ]);
        
        // Verify all submissions belong to this challenge
        $submissionIds = array_filter([
            $validated['first_place'],
            $validated['second_place'] ?? null,
            $validated['third_place'] ?? null,
        ]);
        
        $validSubmissions = Submission::whereIn('id', $submissionIds)
            ->where('challenge_id', $challenge->id)
            ->count();
        
        if ($validSubmissions !== count($submissionIds)) {
            return back()->with('error', 'Invalid submissions selected.');
        }
        
        // Reset all winners first
        $challenge->submissions()->update(['winner_rank' => null]);
        
        // Set new winners
        Submission::find($validated['first_place'])->update(['winner_rank' => 1]);
        
        if (!empty($validated['second_place'])) {
            Submission::find($validated['second_place'])->update(['winner_rank' => 2]);
        }
        
        if (!empty($validated['third_place'])) {
            Submission::find($validated['third_place'])->update(['winner_rank' => 3]);
        }
        
        return redirect()->route('curator.challenges.show', $challenge)
            ->with('success', 'Winners selected successfully!');
    }
}