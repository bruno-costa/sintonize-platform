<?php

namespace App\Utils;

use App\Exceptions\InvalidDataURIException;

class DataURIManipulator
{
    /** @var string */
    private $uri;
    /** @var string */
    private $mimeType;

    /**
     * DataURIManipulator constructor.
     * @param string|null $base64
     * @throws InvalidDataURIException
     */
    public function __construct(string $base64 = null)
    {
        if ($base64 !== null) {
            $this->set($base64);
        }
    }

    /**
     * @param string $base64
     * @throws InvalidDataURIException
     */
    public function set(string $base64)
    {
        $info = $this->info($base64);
        if ($this->validInfo($info)) {
            $this->uri = $base64;
            $this->mimeType = $info['mimeType'];
        } else {
            throw new InvalidDataURIException($base64);
        }
    }

    public function get(): string
    {
        return $this->uri;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    private function info(string $b64)
    {
        preg_match("/^data:(?<mimeType>[^\/]+\/[^;,]+)([;,].*)*$/", $b64, $matchs);
        return $matchs;
    }

    private function validInfo(array $info): bool
    {
        return isset($info[0]) && isset($info['mimeType']);
    }
}
