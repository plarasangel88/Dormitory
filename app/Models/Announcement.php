<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

// Put in: app/Models/Announcement.php
class Announcement extends Model
{
    protected $fillable = ['user_id', 'title', 'body', 'is_pinned'];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Pinned first, then newest
    public function scopeFeed($query)
    {
        return $query->orderByDesc('is_pinned')->latest();
    }
}