<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\ApprovalStatus;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:member,curator'],
        ]);

        $role = $request->role === 'curator' ? UserRole::CURATOR : UserRole::MEMBER;
        
        // Curator needs approval, Member is auto-approved
        $approvalStatus = $role === UserRole::CURATOR 
            ? ApprovalStatus::PENDING 
            : ApprovalStatus::APPROVED;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'approval_status' => $approvalStatus,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->isCurator()) {
            if ($user->approval_status === ApprovalStatus::PENDING) {
                return redirect()->route('curator.pending')
                    ->with('success', 'Registration successful! Please wait for admin approval.');
            }
        }

        return redirect()->route('member.dashboard')
            ->with('success', 'Registration successful! Welcome to ArtShowcase.');
    }
}