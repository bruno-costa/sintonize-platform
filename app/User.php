<?php

namespace App;

use App\Models\Asset;
use App\Models\Radio;
use App\Models\Roles\RoleAdmin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatar()
    {
        return $this->belongsTo(Asset::class, 'avatar_asset_id');
    }

    public function radios()
    {
        return $this->belongsToMany(Radio::class, 'radio_users');
    }

    public function isAdmin(): bool
    {
        return $this->hasOne(RoleAdmin::class)->exists();
    }
}
