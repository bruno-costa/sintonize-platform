<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Asset extends Model
{
    protected $fillable = [
        'id',
        'origin_asset_id',
        'path',
        'disk',
        'md5sum',
        'shasum',
        'size',
        'mime_type',
    ];

    public static function newFromUrl($url): self
    {
        $conversor = new \App\Utils\FileManipulator();
        $file = $conversor->fromURL($url)->toUploadedFile();
        $asset = self::newFromUploadedFile($file);
        $saved = $file->store('public/uploads', 'local');
        $asset->fill([
            'path' => 'storage/' . substr($saved, 7),
            'disk' => 'local',
        ]);
        return $asset;
    }

    public static function newFromUploadedFile(UploadedFile $uploadedFile)
    {
        $asset =  new self;
        $asset->fill([
            'md5sum'=> md5_file($uploadedFile->getRealPath()),
            'shasum' => sha1_file($uploadedFile->getRealPath()),
            'size' => $uploadedFile->getSize(),
            'mime_type' => $uploadedFile->getMimeType(),
        ]);
        return $asset;
    }

    public function original()
    {
        return $this->belongsTo(Asset::class, 'origin_asset_id');
    }

    public function modifieds()
    {
        return $this->hasMany(Asset::class, 'origin_asset_id');
    }

    public function url()
    {
        return '';
    }
}
