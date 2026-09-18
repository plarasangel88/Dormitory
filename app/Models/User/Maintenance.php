<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRequest extends Model
{
    use HasFactory;

    /**
     * Mass-assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'category',
        'title',
        'description',
        'priority',
        'status',
        'admin_notes',
    ];

    /**
     * Default attribute values.
     */
    protected $attributes = [
        'priority' => 'medium',
        'status' => 'pending',
    ];

    /**
     * The student who submitted this request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: only requests belonging to a given user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: only requests with a given status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}