<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Challenge;
use App\Models\Report;
use App\Models\Category;
use App\Enums\UserRole;
use App\Enums\ApprovalStatus;
use App\Enums\ReportStatus;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_users' => User::count(),
            'total_members' => User::where('role', UserRole::MEMBER->value)->count(),
            'total_curators' => User::where('role', UserRole::CURATOR->value)
                ->where('approval_status', ApprovalStatus::APPROVED->value)
                ->count(),
            'pending_curators' => User::where('role', UserRole::CURATOR->value)
                ->where('approval_status', ApprovalStatus::PENDING->value)
                ->count(),
            'total_artworks' => Artwork::count(),
            'total_challenges' => Challenge::count(),
            'total_categories' => Category::count(),
            'pending_reports' => Report::where('status', ReportStatus::PENDING->value)->count(),
        ];
        
        // Recent users
        $recentUsers = User::latest()->take(5)->get();
        
        // Pending curators
        $pendingCurators = User::where('role', UserRole::CURATOR->value)
            ->where('approval_status', ApprovalStatus::PENDING->value)
            ->latest()
            ->take(5)
            ->get();
        
        // Pending reports
        $pendingReports = Report::with(['reporter', 'artwork', 'comment'])
            ->where('status', ReportStatus::PENDING->value)
            ->latest()
            ->take(5)
            ->get();
        
        // Recent artworks
        $recentArtworks = Artwork::with(['user', 'category'])
            ->latest()
            ->take(6)
            ->get();
        
        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'pendingCurators',
            'pendingReports',
            'recentArtworks'
        ));
    }
}