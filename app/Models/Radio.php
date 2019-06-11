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

    protected $casts = [
        'data_array' => 'array'
    ];

    public function avatar()
    {
        return $this->belongsTo(Asset::class, 'avatar_asset_id');
    }

    public function genres()
    {
        return $this->hasManyThrough(Genre::class, RadioGenre::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function avatarUrl(): ?string
    {
        $avatar = $this->avatar;
        if ($avatar) {
            $avatar->url();
        }
        return null;
    }

    public function themeColor(string $themeColor = null): ?string
    {
        $data = $this->data_array ?? [];
        if (func_num_args() === 0) {
            return $data['themeColor'] ?? null;
        } else {
            $this->data_array = [
                    'themeColor' => $themeColor,
                ] + $data;
            return $themeColor;
        }
    }

    public function streamUrl(string $streamUrl = null): ?string
    {
        $data = $this->data_array ?? [];
        if (func_num_args() === 0) {
            return $data['streamUrl'] ?? null;
        } else {
            $this->data_array = [
                    'streamUrl' => $streamUrl,
                ] + $data;
            return $streamUrl;
        }
    }

    public function station(string $station = null): ?string
    {
        $data = $this->data_array ?? [];
        if (func_num_args() === 0) {
            return $data['station'] ?? null;
        } else {
            $this->data_array = [
                    'station' => $station,
                ] + $data;
            return $station;
        }
    }
}
