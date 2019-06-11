<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface;

class Mp3ExtensionGuesser implements ExtensionGuesserInterface
{


    /**
     * Makes a best guess for a file extension, given a mime type.
     *
     * @param string $mimeType The mime type
     *
     * @return string The guessed extension or NULL, if none could be guessed
     */
    public function guess($mimeType)
    {
        return [
            'audio/mp3' => 'mp3'
            ][$mimeType] ?? null;
    }
}
