<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    use DynamicAttributeTrait;

    protected $dynamicAttributeProp = 'data_array';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'city',
        'estate',
        'avatar_asset_id',
    ];

    protected $casts = [
        'data_array' => 'array'
    ];

    public function avatar()
    {
        return $this->belongsTo(Asset::class, 'avatar_asset_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'radio_genres');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'radio_users');
    }

    public function avatarUrl(): ?string
    {
        $avatar = $this->avatar;
        if ($avatar) {
            return $avatar->url();
        }
        return null;
    }

    public function themeColor(string $themeColor = null): ?string
    {
        return $this->dynamicAttributeMutator('themeColor', func_get_args());
    }

    public function streamUrl(string $streamUrl = null): ?string
    {
        return $this->dynamicAttributeMutator('streamUrl', func_get_args());
    }

    public function station(string $station = null): ?string
    {
        return $this->dynamicAttributeMutator('station', func_get_args());
    }
}
