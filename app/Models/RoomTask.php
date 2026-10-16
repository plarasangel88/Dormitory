<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomTask extends Model
{
    protected $fillable = [
        'room_id', 'assigned_to', 'assigned_by',
        'title', 'task_date', 'is_done', 'completed_at',
    ];

    protected $casts = [
        'task_date'    => 'date',
        'is_done'      => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}