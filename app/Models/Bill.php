<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public const ITEMS = ['rent', 'electricity', 'water'];

    protected $fillable = ['student_id','room_id','billing_month','rent','electricity','water','due_date','remarks'];
    protected $casts = ['billing_month' => 'date', 'due_date' => 'date'];

    public function student()  { return $this->belongsTo(User::class, 'student_id'); }
    public function room()     { return $this->belongsTo(Room::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function getTotalAttribute(): float
    {
        return (float) ($this->rent + $this->electricity + $this->water);
    }

    // Only admin-verified payments count
    public function paidFor(string $item): float
    {
        return (float) $this->payments->where('status', 'verified')->where('applies_to', $item)->sum('amount');
    }

    public function balanceFor(string $item): float
    {
        return max(0, (float) $this->$item - $this->paidFor($item));
    }

    public function getBalanceAttribute(): float
    {
        return collect(self::ITEMS)->sum(fn ($i) => $this->balanceFor($i));
    }
}
