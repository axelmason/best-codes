<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const MODERATE_ROLE_ID = 2;

    protected $fillable = [
        'login',
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function code()
    {
        return $this->belongsTo(Code::class);
    }

    public function moderate_codes()
    {
        return $this->hasMany(Code::class, 'moderator_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
