<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ReportStatus;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'artwork_id',
        'comment_id',
        'reason',
        'description',
        'status',
        'reviewed_by',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'status' => ReportStatus::class,
        'reviewed_at' => 'datetime',
    ];

    protected $with = ['reporter'];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', ReportStatus::PENDING);
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', '!=', ReportStatus::PENDING);
    }

    // Helper methods
    public function isPending(): bool
    {
        return $this->status === ReportStatus::PENDING;
    }

    public function getReportedContentAttribute()
    {
        if ($this->artwork_id) {
            return $this->artwork;
        }
        return $this->comment;
    }

    public function getReportedTypeAttribute()
    {
        return $this->artwork_id ? 'Artwork' : 'Comment';
    }
}