<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'id', 'description'
    ];

    public function radios()
    {
        return $this->hasManyThrough(Radio::class, 'radio_genres');
    }
}
