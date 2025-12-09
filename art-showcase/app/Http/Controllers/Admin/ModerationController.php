<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Enums\ReportStatus;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['reporter', 'artwork.user', 'comment.user', 'reviewer']);
        
        // Filter by status
        $status = $request->get('status', 'pending');
        
        if ($status === 'pending') {
            $query->where('status', ReportStatus::PENDING);
        } elseif ($status === 'reviewed') {
            $query->where('status', '!=', ReportStatus::PENDING);
        }
        
        // Filter by type
        if ($request->has('type')) {
            if ($request->type === 'artwork') {
                $query->whereNotNull('artwork_id');
            } elseif ($request->type === 'comment') {
                $query->whereNotNull('comment_id');
            }
        }
        
        $reports = $query->latest()->paginate(15);
        
        // Stats
        $stats = [
            'pending' => Report::where('status', ReportStatus::PENDING)->count(),
            'dismissed' => Report::where('status', ReportStatus::DISMISSED)->count(),
            'taken_down' => Report::where('status', ReportStatus::TAKEN_DOWN)->count(),
            'total' => Report::count(),
        ];
        
        return view('admin.moderation.index', compact('reports', 'status', 'stats'));
    }
    
    public function show(Report $report)
    {
        $report->load([
            'reporter',
            'artwork.user',
            'artwork.category',
            'comment.user',
            'comment.artwork',
            'reviewer'
        ]);
        
        return view('admin.moderation.show', compact('report'));
    }
    
    public function dismiss(Request $request, Report $report)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);
        
        $report->update([
            'status' => ReportStatus::DISMISSED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? 'Report dismissed - no violation found.',
        ]);
        
        return redirect()->route('admin.moderation.index')
            ->with('success', 'Report has been dismissed successfully.');
    }
    
    public function takedown(Request $request, Report $report)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);
        
        // Delete the reported content
        if ($report->artwork_id) {
            $contentType = 'Artwork';
            $report->artwork->delete();
        } elseif ($report->comment_id) {
            $contentType = 'Comment';
            $artwork = $report->comment->artwork;
            $report->comment->delete();
            $artwork->decrementCommentsCount();
        }
        
        // Update report status
        $report->update([
            'status' => ReportStatus::TAKEN_DOWN,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_notes' => $validated['admin_notes'],
        ]);
        
        return redirect()->route('admin.moderation.index')
            ->with('success', "{$contentType} has been removed successfully.");
    }
}