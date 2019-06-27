<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    protected $fillable = [
        'id',
        'name',
        'avatar_asset_id',
        'url',
    ];

    public function avatar()
    {
        return $this->belongsTo(Asset::class, 'avatar_asset_id');
    }

    public function avatarUrl(): ?string
    {
        $img = $this->avatar;
        if ($img) {
            return $img->url();
        }
        return null;
    }
}
