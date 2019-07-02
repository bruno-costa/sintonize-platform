<?php

namespace App\Models;

use App\Repositories\Promotions\PromotionAbstract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use DynamicAttributeTrait;
    use SoftDeletes;

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
        return $this->belongsToMany(Advertiser::class, 'content_advertisers');
    }

    /**
     * @return Advertiser|null
     */
    public function advertiser(): ?Advertiser
    {
        return $this->advertisers()->first();
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
}
