<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Guest\ArtworkController as GuestArtworkController;
use App\Http\Controllers\Guest\ChallengeController as GuestChallengeController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\ArtworkController as MemberArtworkController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\InteractionController;
use App\Http\Controllers\Member\SubmissionController;
use App\Http\Controllers\Curator\DashboardController as CuratorDashboardController;
use App\Http\Controllers\Curator\ChallengeController as CuratorChallengeController;
use App\Http\Controllers\Curator\WinnerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ModerationController;
use Illuminate\Support\Facades\Route;

// Guest Routes (Public)
Route::get('/', [GuestHomeController::class, 'index'])->name('home');
Route::get('/artworks', [GuestArtworkController::class, 'index'])->name('guest.artworks.index');
Route::get('/artworks/{artwork}', [GuestArtworkController::class, 'show'])->name('guest.artworks.show');
Route::get('/challenges', [GuestChallengeController::class, 'index'])->name('guest.challenges.index');
Route::get('/challenges/{challenge}', [GuestChallengeController::class, 'show'])->name('guest.challenges.show');
Route::get('/profile/{user}', [GuestArtworkController::class, 'profile'])->name('guest.profile');

// Auth Routes (Laravel Breeze)
require __DIR__.'/auth.php';

// Member Routes
Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
    
    // Artworks
    Route::resource('artworks', MemberArtworkController::class);
    
    // Profile
    Route::get('/profile', [MemberProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [MemberProfileController::class, 'update'])->name('profile.update');
    Route::patch('/account', [MemberProfileController::class, 'updateAccount'])->name('account.update');
    
    // Favorites
    Route::get('/favorites', [MemberDashboardController::class, 'favorites'])->name('favorites');
    
    // Submissions
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
    
    // Interactions
    Route::post('/artworks/{artwork}/like', [InteractionController::class, 'like'])->name('artworks.like');
    Route::post('/artworks/{artwork}/favorite', [InteractionController::class, 'favorite'])->name('artworks.favorite');
    Route::post('/artworks/{artwork}/comment', [InteractionController::class, 'comment'])->name('artworks.comment');
    Route::delete('/comments/{comment}', [InteractionController::class, 'deleteComment'])->name('comments.destroy');
    Route::post('/artworks/{artwork}/report', [InteractionController::class, 'report'])->name('artworks.report');
    Route::post('/comments/{comment}/report', [InteractionController::class, 'reportComment'])->name('comments.report');
});

// Curator Routes
Route::middleware(['auth', 'role:curator'])->prefix('curator')->name('curator.')->group(function () {
    // Pending & Rejected Pages
    Route::get('/pending', function () {
        return view('curator.pending');
    })->name('pending')->withoutMiddleware('curator.approved');
    
    Route::get('/rejected', function () {
        return view('curator.rejected');
    })->name('rejected')->withoutMiddleware('curator.approved');
    
    Route::delete('/account', [CuratorDashboardController::class, 'deleteAccount'])->name('account.delete');
    
    // Dashboard (hanya untuk yang approved)
    Route::middleware('curator.approved')->group(function () {
        Route::get('/dashboard', [CuratorDashboardController::class, 'index'])->name('dashboard');
        
        // Challenges
        Route::resource('challenges', CuratorChallengeController::class);
        Route::get('/challenges/{challenge}/submissions', [CuratorChallengeController::class, 'submissions'])->name('challenges.submissions');
        
        // Winners
        Route::get('/challenges/{challenge}/winners', [WinnerController::class, 'index'])->name('challenges.winners.index');
        Route::post('/challenges/{challenge}/winners', [WinnerController::class, 'store'])->name('challenges.winners.store');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/approve', [UserManagementController::class, 'approve'])->name('users.approve');
    Route::patch('/users/{user}/reject', [UserManagementController::class, 'reject'])->name('users.reject');
    
    // Category Management
    Route::resource('categories', CategoryController::class);
    
    // Moderation
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::get('/reports/{report}', [ModerationController::class, 'show'])->name('reports.show');
    Route::patch('/reports/{report}/dismiss', [ModerationController::class, 'dismiss'])->name('reports.dismiss');
    Route::delete('/reports/{report}/takedown', [ModerationController::class, 'takedown'])->name('reports.takedown');
});