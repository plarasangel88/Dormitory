<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'monthly_rate',
        'capacity',
        // add whatever columns your rooms table actually has
    ];

    /**
     * Get the users assigned to this room.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}