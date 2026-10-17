<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bill_id',
        'applies_to',
        'amount',
        'method',
        'status',
        'payment_date',
        'reference_number',
        'provider_reference',
        'notes',
        'qr_token',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }
}
