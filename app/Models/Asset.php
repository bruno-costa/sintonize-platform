<?php

namespace App\Models;

use App\Http\Controllers\AssetController;
use App\Services\ImageProcessorService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Storage;
use Symfony\Component\Mime\MimeTypes;

class Asset extends Model
{
    private $localPath = null;
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

    /**
     * @param UploadedFile $uploadedFile
     * @return Asset
     * @throws \Exception
     */
    public static function createLocalFromUploadedFile(UploadedFile $uploadedFile)
    {
        $asset = self::newFromLocalFile($uploadedFile->getRealPath());
        $asset->storageDiskLocal();
        $asset->save();
        return $asset;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return Asset
     * @throws \Exception
     */
    public static function createDOSpacesFromUploadedFile(UploadedFile $uploadedFile, $path, $prefix = '')
    {
        $asset = self::newFromLocalFile($uploadedFile->getRealPath());
        $asset->storageDiskDigitalOceanSpaces($path, $prefix);
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

    public function isDiskLocal(): bool
    {
        return $this->disk == 'local';
    }

    public function isDiskRealpath(): bool
    {
        return $this->disk == 'realpath';
    }

    public function isDiskDOSpaces(): bool
    {
        return $this->disk == 'do_spaces';
    }


    /**
     * @return string
     * @throws \UnexpectedValueException
     * @throws \Exception
     */
    public function getLocalPath(): string
    {
        if ($this->localPath) {
            if (is_file($this->localPath)) {
                return $this->localPath;
            } else {
                throw new \RuntimeException("localpath \"{$this->localPath}\" is not a file");
            }
        }

        if ($this->isDiskLocal()) {
            $this->localPath = storage_path('app/public/' . $this->path);
            return $this->getLocalPath();
        }
        if ($this->isDiskRealpath()) {
            $this->localPath = $this->path;
            return $this->getLocalPath();
        }
        if ($this->isDiskDOSpaces()) {
            $tempfile = tempnam(sys_get_temp_dir(), 'cfdo_');
            if (!$tempfile) {
                throw new \Exception("can't create temp file");
            }
            $fileData = Storage::disk('do_spaces')->get($this->path);
            file_put_contents($tempfile, $fileData);
            $this->localPath = $tempfile;
            return $this->getLocalPath();
        }

        throw new \UnexpectedValueException("disk \"{$this->disk}\" unexpected");
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function storageDiskLocal(): bool
    {
        $localPath = $this->getLocalPath();
        $name = Str::random(40);
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
     * @param string $path
     * @param string $prefix
     * @return bool
     * @throws \Exception
     */
    public function storageDiskDigitalOceanSpaces(string $path, $prefix = ''): bool
    {
        $localPath = $this->getLocalPath();
        $extension = pathinfo($localPath)['extension'] ?? null;
        if ($extension === null) {
            $extension = MimeTypes::getDefault()->getExtensions($this->mime_type)[0] ?? null;
        }
        if ($extension) {
            $extension = ".$extension";
        }
        $name = $prefix . Str::random(40) . $extension;

        $newPath = trim(env('DO_SPACES_ASSETS_PATH') . "/$path/$name", '/');
        $stream = fopen($localPath, 'r');
        $options = [
            'visibility' => 'private',
            'mimetype' => $this->mime_type
        ];
        $result = Storage::disk('do_spaces')->put($newPath, $stream, $options);

        if (is_resource($stream)) {
            fclose($stream);
        }

        if ($result) {
            $this->path = $newPath;
            $this->disk = 'do_spaces';
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
