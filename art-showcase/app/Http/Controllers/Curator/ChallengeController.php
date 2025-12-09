<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = auth()->user()->challenges()
            ->withCount('submissions')
            ->latest()
            ->paginate(9);
        
        return view('curator.challenges.index', compact('challenges'));
    }
    
    public function create()
    {
        return view('curator.challenges.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'nullable|string',
            'prize' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);
        
        if ($request->hasFile('banner_image')) {
            $banner = $request->file('banner_image');
            $bannerName = time() . '_' . $banner->getClientOriginalName();
            $bannerPath = $banner->storeAs('challenges', $bannerName, 'public');
            $validated['banner_image'] = $bannerPath;
        }
        
        $validated['curator_id'] = auth()->id();
        $validated['is_active'] = true;
        
        Challenge::create($validated);
        
        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge created successfully!');
    }
    
    public function show(Challenge $challenge)
    {
        // Ensure curator owns this challenge
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }
        
        $challenge->loadCount('submissions');
        
        $stats = [
            'total_submissions' => $challenge->submissions()->count(),
            'has_winners' => $challenge->hasWinners(),
            'days_remaining' => $challenge->hasEnded() ? 0 : now()->diffInDays($challenge->end_date),
        ];
        
        return view('curator.challenges.show', compact('challenge', 'stats'));
    }
    
    public function edit(Challenge $challenge)
    {
        // Ensure curator owns this challenge
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }
        
        return view('curator.challenges.edit', compact('challenge'));
    }
    
    public function update(Request $request, Challenge $challenge)
    {
        // Ensure curator owns this challenge
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'nullable|string',
            'prize' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_active' => 'boolean',
        ]);
        
        if ($request->hasFile('banner_image')) {
            // Delete old banner
            if ($challenge->banner_image) {
                Storage::disk('public')->delete($challenge->banner_image);
            }
            
            $banner = $request->file('banner_image');
            $bannerName = time() . '_' . $banner->getClientOriginalName();
            $bannerPath = $banner->storeAs('challenges', $bannerName, 'public');
            $validated['banner_image'] = $bannerPath;
        }
        
        $challenge->update($validated);
        
        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge updated successfully!');
    }
    
    public function destroy(Challenge $challenge)
    {
        // Ensure curator owns this challenge
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }
        
        // Delete banner image
        if ($challenge->banner_image) {
            Storage::disk('public')->delete($challenge->banner_image);
        }
        
        $challenge->delete();
        
        return redirect()->route('curator.challenges.index')
            ->with('success', 'Challenge deleted successfully!');
    }
    
    public function submissions(Challenge $challenge)
    {
        // Ensure curator owns this challenge
        if ($challenge->curator_id !== auth()->id()) {
            abort(403);
        }
        
        $submissions = $challenge->submissions()
            ->with(['artwork.user', 'artwork.category'])
            ->orderByRaw('winner_rank IS NULL')
            ->orderBy('winner_rank')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('curator.challenges.submissions', compact('challenge', 'submissions'));
    }
}