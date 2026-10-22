<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentAudit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'actor_id',
        'student_id',
        'reference_number',
        'action',
        'previous_status',
        'new_status',
        'amount',
        'details',
        'created_at',
    ];

    protected function casts(): array
    {
        return ['details' => 'array', 'created_at' => 'datetime', 'amount' => 'decimal:2'];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
