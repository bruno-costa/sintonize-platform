<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class RoleAdmin extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'user_id';
}
