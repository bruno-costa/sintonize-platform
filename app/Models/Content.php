<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'id',
        'radio_id',
        'text',
        'image_asset_id',
        'action_label',
        'action_url',
        'promotion_array',
    ];

    protected $casts = [
        'promotion_array' => 'array'
    ];

    public function radio()
    {
        $this->belongsTo(Radio::class);
    }

    public function image()
    {
        $this->belongsTo(Asset::class, 'image_asset_id');
    }
}
