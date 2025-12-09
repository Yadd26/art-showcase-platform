<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Enums\UserRole;
use App\Enums\ApprovalStatus;

class RegisterController extends Controller
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
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:member,curator'],
        ]);

        $approvalStatus = $request->role === 'curator' 
            ? ApprovalStatus::PENDING 
            : ApprovalStatus::APPROVED;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'approval_status' => $approvalStatus,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect berdasarkan role
        if ($user->role === UserRole::CURATOR && $user->approval_status === ApprovalStatus::PENDING) {
            return redirect()->route('curator.pending');
        }

        return redirect()->route('member.dashboard');
    }
}