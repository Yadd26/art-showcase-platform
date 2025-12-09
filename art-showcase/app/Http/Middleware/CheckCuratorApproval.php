<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserRole;
use App\Enums\ApprovalStatus;

class CheckCuratorApproval
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Hanya cek untuk curator
        if ($user->role === UserRole::CURATOR) {
            if ($user->approval_status === ApprovalStatus::PENDING) {
                return redirect()->route('curator.pending');
            }

            if ($user->approval_status === ApprovalStatus::REJECTED) {
                return redirect()->route('curator.rejected');
            }
        }

        return $next($request);
    }
}