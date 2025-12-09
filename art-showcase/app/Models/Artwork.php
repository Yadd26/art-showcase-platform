<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image_path',
        'tags',
        'likes_count',
        'comments_count',
        'favorites_count',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    protected $with = ['user', 'category'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // Scopes
    public function scopePopular($query)
    {
        return $query->orderBy('likes_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->latest();
    }

    public function scopeFeatured($query)
    {
        return $query->where('likes_count', '>', 10)->latest();
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Helper methods
    public function incrementLikesCount()
    {
        $this->increment('likes_count');
    }

    public function decrementLikesCount()
    {
        $this->decrement('likes_count');
    }

    public function incrementCommentsCount()
    {
        $this->increment('comments_count');
    }

    public function decrementCommentsCount()
    {
        $this->decrement('comments_count');
    }

    public function incrementFavoritesCount()
    {
        $this->increment('favorites_count');
    }

    public function decrementFavoritesCount()
    {
        $this->decrement('favorites_count');
    }
}