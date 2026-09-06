<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'amount', 'method', 'reference_number', 'status', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}