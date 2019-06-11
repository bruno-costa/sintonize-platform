<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;

class LocalFile
{
    /** @var string */
    private $path;
    /** @var string */
    private $md5sum;
    /** @var string */
    private $shasum;
    /** @var int */
    private $size;
    /** @var string */
    private $mimeType;

    /**
     * LocalFile constructor.
     * @param $localPath
     * @throws \RuntimeException
     */
    public function __construct($localPath)
    {
        if (file_exists($localPath)) {
            $this->path = realpath($localPath);
        } else {
            throw new \RuntimeException("file not found: '{$localPath}'");
        }
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function md5sum()
    {
        if ($this->md5sum) {
            return $this->md5sum;
        }
        $this->md5sum = md5_file($this->path);
        return $this->md5sum();
    }

    /**
     * @return string
     */
    public function shasum()
    {
        if ($this->shasum) {
            return $this->shasum;
        }
        $this->shasum = sha1_file($this->path);
        return $this->shasum();
    }

    /**
     * @return int
     */
    public function size()
    {
        if ($this->size) {
            return $this->size;
        }
        $this->size = filesize($this->path);
        return $this->size();
    }

    /**
     * @return string
     */
    public function mimeType()
    {
        if ($this->mimeType) {
            return $this->mimeType;
        }
        $this->mimeType = mime_content_type($this->path);
        return $this->mimeType();
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile(): UploadedFile
    {
        return new UploadedFile($this->path, basename($this->path), $this->mimeType());
    }
}
