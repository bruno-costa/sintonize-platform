<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    protected $fillable = [
        'id',
        'facebook_id',
        'name',
        'phone_number',
        'gender',
        'birthday',
    ];

    public $incrementing = false;

    public function participations()
    {
        return $this->hasMany(ContentParticipation::class);
    }
}
