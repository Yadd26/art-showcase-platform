<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\ApprovalStatus;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        // Filter by approval status
        if ($request->has('status') && $request->status != '') {
            $query->where('approval_status', $request->status);
        }
        
        // Search by name or email
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%");
            });
        }
        
        $users = $query->latest()->paginate(15);
        
        // Count by role for stats
        $roleStats = [
            'all' => User::count(),
            'admin' => User::where('role', UserRole::ADMIN->value)->count(),
            'member' => User::where('role', UserRole::MEMBER->value)->count(),
            'curator' => User::where('role', UserRole::CURATOR->value)->count(),
            'pending_curator' => User::where('role', UserRole::CURATOR->value)
                ->where('approval_status', ApprovalStatus::PENDING->value)
                ->count(),
        ];
        
        return view('admin.users.index', compact('users', 'roleStats'));
    }
    
    public function destroy(User $user)
    {
        // Cannot delete self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        // Cannot delete other admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin users.');
        }
        
        $userName = $user->name;
        $user->delete();
        
        return back()->with('success', "User '{$userName}' has been deleted successfully.");
    }
    
    public function approve(User $user)
    {
        if (!$user->isCurator()) {
            return back()->with('error', 'Only curators can be approved.');
        }
        
        if ($user->isApproved()) {
            return back()->with('info', 'This curator is already approved.');
        }
        
        $user->update(['approval_status' => ApprovalStatus::APPROVED]);
        
        return back()->with('success', "Curator '{$user->name}' has been approved successfully.");
    }
    
    public function reject(User $user)
    {
        if (!$user->isCurator()) {
            return back()->with('error', 'Only curators can be rejected.');
        }
        
        $user->update(['approval_status' => ApprovalStatus::REJECTED]);
        
        return back()->with('success', "Curator '{$user->name}' has been rejected.");
    }
}