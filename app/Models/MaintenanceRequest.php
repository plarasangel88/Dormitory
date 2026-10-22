<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'title',
        'description',
        'priority',
        'status',
        'admin_notes',
        'resolved_by',
        'resolved_at',
        'assigned_to',
        'due_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(MaintenanceMessage::class)->oldest();
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'in_progress' => 'info',
            'completed' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
