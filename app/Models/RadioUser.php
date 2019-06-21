<?php

namespace App\Models;

use App\Models\Traits\MultiplePrimaryKeys;
use Illuminate\Database\Eloquent\Model;

class RadioUser extends Model
{
    use MultiplePrimaryKeys;

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = ['radio_id', 'user_id'];
}
