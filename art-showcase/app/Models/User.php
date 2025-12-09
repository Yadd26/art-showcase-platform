<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;
use App\Enums\ApprovalStatus;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'approval_status',
        'bio',
        'display_name',
        'profile_photo',
        'external_link',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'approval_status' => ApprovalStatus::class,
        ];
    }

    // Relationships
    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class, 'curator_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isMember(): bool
    {
        return $this->role === UserRole::MEMBER;
    }

    public function isCurator(): bool
    {
        return $this->role === UserRole::CURATOR;
    }

    public function isApproved(): bool
    {
        return $this->approval_status === ApprovalStatus::APPROVED;
    }

    public function isPending(): bool
    {
        return $this->approval_status === ApprovalStatus::PENDING;
    }

    public function getDisplayNameAttribute($value)
    {
        return $value ?? $this->name;
    }

    public function hasLiked(Artwork $artwork): bool
    {
        return $this->likes()->where('artwork_id', $artwork->id)->exists();
    }

    public function hasFavorited(Artwork $artwork): bool
    {
        return $this->favorites()->where('artwork_id', $artwork->id)->exists();
    }
}