<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    protected $fillable = [
        'id',
        'name',
        'phone_number',
        'gender',
        'birthday',
    ];
}
