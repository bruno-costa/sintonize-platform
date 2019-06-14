<?php

namespace App\Models;

use App\Repositories\Promotions\PromotionAbstract;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use DynamicAttributeTrait;

    protected $dynamicAttributeProp = 'promotion_array';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'radio_id',
        'text',
        'image_asset_id',
        'promotion_array',
    ];

    protected $casts = [
        'promotion_array' => 'array'
    ];

    public function advertisers()
    {
        //$this->hasManyThrough(Advertiser::class, ContentAdvertiser::class)->first();
    }

    public function radio()
    {
        $this->belongsTo(Radio::class);
    }

    public function image()
    {
        return $this->belongsTo(Asset::class, 'image_asset_id');
    }

    public function participations()
    {
        return $this->hasMany(ContentParticipation::class);
    }

    public function imageUrl(): ?string
    {
        $img = $this->image;
        if ($img) {
            return $img->url();
        }
        return null;
    }

    public function rulesText(string $rulesText = null)
    {
        return $this->dynamicAttributeMutator('rulesText', func_get_args());
    }

    public function promotion(PromotionAbstract $promotion = null): ?PromotionAbstract
    {
        $data = $this->dynamicAttributeMutator('promotion', $promotion ? [$promotion->storeData()] : []);
        if ($data === null) {
            return null;
        }
        return PromotionAbstract::restoreData($data, $this);
    }

    public function winCode()
    {
        return null;
    }
}
