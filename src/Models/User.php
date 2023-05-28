<?php

namespace Ajifatur\FaturHelper\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'access_token', 'remember_token', 'avatar', 'status', 'last_visit', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'access_token', 'remember_token',
    ];

    /**
     * Get the attribute associated with the user.
     */
    public function attribute()
    {
        return $this->hasOne(UserAttribute::class);
    }

    /**
     * Get the account associated with the user.
     */
    public function account()
    {
        return $this->hasOne(UserAccount::class);
    }

    /**
     * Get the avatars for the user.
     */
    public function avatars()
    {
        return $this->hasMany(UserAvatar::class);
    }

    /**
     * Get the visits for the user.
     */
    public function visits()
    {
        return $this->hasMany(Visitor::class);
    }
    
    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user__role', 'user_id', 'role_id');
    }
}
