<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\Auditable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Auditable, Sluggable;

    protected $fillable = [
        'first_name', 'last_name', 'full_name', 'email', 'phone_no', 'token', 'password',
        'status', 'role_id', 'social_id', 'social_type', 'approval_status', 'login_first_time',
        'phone_number_verify', 'creater_id', 'token_expiry_time', 'last_ip', 'last_latitude', 'last_longitude'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'full_name',
                'onUpdate' => true
            ]
        ];
    }
}
