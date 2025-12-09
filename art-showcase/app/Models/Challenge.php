<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'curator_id',
        'title',
        'description',
        'rules',
        'prize',
        'banner_image',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected $with = ['curator'];

    public function curator()
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function winners()
    {
        return $this->submissions()->whereNotNull('winner_rank')->orderBy('winner_rank');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '>', now());
    }

    public function scopeEnded($query)
    {
        return $query->where('end_date', '<', now());
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->is_active 
            && Carbon::parse($this->start_date)->isPast()
            && Carbon::parse($this->end_date)->isFuture();
    }

    public function hasEnded(): bool
    {
        return Carbon::parse($this->end_date)->isPast();
    }

    public function canSubmit(): bool
    {
        return $this->isActive();
    }

    public function canSelectWinners(): bool
    {
        return $this->hasEnded();
    }

    public function getSubmissionsCountAttribute()
    {
        return $this->submissions()->count();
    }

    public function hasWinners(): bool
    {
        return $this->submissions()->whereNotNull('winner_rank')->exists();
    }
}