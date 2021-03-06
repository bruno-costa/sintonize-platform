<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentAdvertiser extends Model
{
    protected $fillable = [
        'content_id',
        'advertiser_id',
        'image_asset_id',
        'url',
    ];


    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    public function imageAsset()
    {
        return $this->belongsTo(Asset::class, 'image_asset_id');
    }
}
