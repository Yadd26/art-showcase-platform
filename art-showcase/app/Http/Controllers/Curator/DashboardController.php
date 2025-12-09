<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistics
        $stats = [
            'total_challenges' => $user->challenges()->count(),
            'active_challenges' => $user->challenges()->active()->count(),
            'ended_challenges' => $user->challenges()->ended()->count(),
            'total_submissions' => $user->challenges()->withCount('submissions')->get()->sum('submissions_count'),
        ];
        
        // Recent challenges
        $recentChallenges = $user->challenges()
            ->withCount('submissions')
            ->latest()
            ->take(5)
            ->get();
        
        // Active challenges
        $activeChallenges = $user->challenges()
            ->active()
            ->withCount('submissions')
            ->get();
        
        // Challenges needing winner selection
        $needsWinnerSelection = $user->challenges()
            ->ended()
            ->whereDoesntHave('winners')
            ->withCount('submissions')
            ->get();
        
        return view('curator.dashboard', compact(
            'stats',
            'recentChallenges',
            'activeChallenges',
            'needsWinnerSelection'
        ));
    }
    
    public function deleteAccount()
    {
        $user = auth()->user();
        
        // Only allow if rejected
        if ($user->approval_status->value !== 'rejected') {
            abort(403, 'Only rejected curators can delete their account.');
        }
        
        auth()->logout();
        $user->delete();
        
        return redirect()->route('home')->with('success', 'Your account has been deleted successfully.');
    }
}