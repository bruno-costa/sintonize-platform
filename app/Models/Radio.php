<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'city',
        'estate',
        'avatar_asset_id',
    ];

    public function avatar()
    {
        return $this->belongsTo(Asset::class, 'avatar_asset_id');
    }

    public function genres()
    {
        return $this->hasManyThrough(Genre::class, 'radio_genres');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
