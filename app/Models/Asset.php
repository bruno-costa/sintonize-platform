<?php

namespace App\Models;

use App\Http\Controllers\AssetController;
use App\Services\ImageProcessorService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\Mime\MimeTypes;

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

    public static function newLocalFromUrl($url): self
    {
        $conversor = new \App\Utils\FileManipulator();
        $file = $conversor->fromURL($url)->toUploadedFile();
        $asset = self::newFromLocalFile($file->getRealPath());
        $asset->storageDiskLocal();
        return $asset;
    }

    /**
     * @param string $path
     * @return Asset
     * @throws \InvalidArgumentException
     */
    public static function newFromLocalFile(string $path): Asset
    {
        if (is_file($path)) {
            $asset = new self;
            $asset->fill([
                'md5sum' => md5_file($path),
                'shasum' => sha1_file($path),
                'size' => filesize($path),
                'mime_type' => mime_content_type($path),
                'path' => $path,
                'disk' => 'realpath'
            ]);
            return $asset;
        }
        throw new \InvalidArgumentException("path \"{$path}\" is not a file");
    }


    public static function createLocalFromUploadedFile(UploadedFile $uploadedFile)
    {
        $asset = self::newFromLocalFile($uploadedFile->getRealPath());
        $asset->storageDiskLocal();
        $asset->save();
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
        return AssetController::url($this);
    }

    /**
     * @throws \UnexpectedValueException
     * @return string
     */
    public function getLocalPath(): string
    {
        if ($this->disk == 'local') {
            return storage_path('app/public/' . $this->path);
        }
        if ($this->disk == 'realpath') {
            return $this->path;
        }

        throw new \UnexpectedValueException("disk \"{$this->disk}\" unexpected");
    }

    public function storageDiskLocal(): bool
    {
        $localPath = $this->getLocalPath();
        $extension = pathinfo($localPath)['extension'] ?? null;
        if ($extension === null) {
            $extension = MimeTypes::getDefault()->getExtensions($this->mime_type)[0] ?? null;
        }
        if ($extension) {
            $extension = ".$extension";
        }
        $name = Str::random(40) . $extension;
        $newPath = "uploads/$name";
        if (copy($localPath, storage_path("app/public/$newPath"))) {
            $this->path = $newPath;
            $this->disk = 'local';
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $width
     * @param int $height
     * @throws \Exception
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function optimizeImage(int $width, int $height)
    {
        $processor = new ImageProcessorService();
        $path = $processor->process($this->getLocalPath(), $width, $height);
        $newAsset = $this->newFromLocalFile($path);
        $newAsset->fill([
            'origin_asset_id' => $this->id,
        ]);
        return $newAsset;
    }
}
