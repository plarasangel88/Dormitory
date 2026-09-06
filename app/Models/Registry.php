<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Registry extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'registers';

    protected $fillable = [
        'name',
        'email',
        'course',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}