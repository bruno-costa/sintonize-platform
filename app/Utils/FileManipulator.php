<?php

namespace App\Utils;

use App\Exceptions\CantGetContentTypeException;
use Illuminate\Http\UploadedFile;

class FileManipulator
{
    private $kind = null;
    private $data = null;
    private const KIND = [
        "DATA_URI" => "DATA_URI",
        "URL" => "URL",
        "UPLOADED_FILE" => "UPLOADED_FILE",
    ];

    private const CONVERSOR = [
        self::KIND["DATA_URI"] => [
            self::KIND["UPLOADED_FILE"] => "fromDataURIManipulatorToUploadedFile",
            self::KIND["DATA_URI"] => "return"
        ],
        self::KIND["URL"] => [
            self::KIND["UPLOADED_FILE"] => "fromURLToUploadedFile",
            self::KIND["DATA_URI"] => "fromURLToDataUri"
        ],
        self::KIND["UPLOADED_FILE"] => [
            self::KIND["UPLOADED_FILE"] => "return",
            self::KIND["DATA_URI"] => "fromUploadedFileToDataUri"
        ]
    ];

    public function fromDataURI(string $dataUri): self
    {
        $this->kind = self::KIND["DATA_URI"];
        $this->data = new DataURIManipulator($dataUri);
        return $this;
    }

    public function fromURL(string $url): self
    {
        $this->kind = self::KIND["URL"];
        $this->data = $url;
        return $this;
    }

    public function toUploadedFile(): UploadedFile
    {
        $method = self::CONVERSOR[$this->kind][self::KIND["UPLOADED_FILE"]];
        return self::$method($this->data);
    }

    public function toDataURI(): string
    {
        $method = self::CONVERSOR[$this->kind][self::KIND["DATA_URI"]];
        return self::$method($this->data);
    }

    static private function return($data)
    {
        // method to workflow run correctly
        return $data;
    }

    static public function fromDataURIToUploadedFile(string $dataUri): UploadedFile
    {
        return self::fromDataURIManipulatorToUploadedFile(new DataURIManipulator($dataUri));
    }

    static public function fromDataURIManipulatorToUploadedFile(DataURIManipulator $dataUri): UploadedFile
    {
        $name = tempnam('/tmp', "starfan.");
        file_put_contents($name, file_get_contents($dataUri->get()));
        return new UploadedFile($name, basename($name), $dataUri->getMimeType());
    }

    /**
     * @param string $url
     * @return UploadedFile
     * @throws CantGetContentTypeException
     */
    static public function fromURLToUploadedFile(string $url): UploadedFile
    {
        list($name, $mimeType) = self::download($url);
        return new UploadedFile($name, basename($name), $mimeType);
    }

    /**
     * @param string $url
     * @return string
     * @throws CantGetContentTypeException
     */
    static public function fromURLToDataUri(string $url): string
    {
        list($name, $mimeType) = self::download($url);
        $data = base64_encode(file_get_contents($name));
        return (new DataURIManipulator("data:$mimeType;base64,$data"))->get();
    }

    static public function fromUploadedFileToDataUri(UploadedFile $file): string
    {
        $mimeType = $file->getMimeType();
        $data = base64_encode(file_get_contents($file->getFilename()));
        return (new DataURIManipulator("data:$mimeType;base64,$data"))->get();
    }

    /**
     * @param $url
     * @return array
     * @throws CantGetContentTypeException
     */
    static private function download($url)
    {
        $name = tempnam('/tmp', "starfan.");
        file_put_contents($name, file_get_contents($url));
        $mimeType = self::getContentType($http_response_header);
        if (!$mimeType) {
            throw new CantGetContentTypeException();
        }
        return [$name, $mimeType];
    }

    static private function getContentType(array $response_header): string
    {
        foreach ($response_header as $header) {
            if (preg_match("/^Content-Type:\s*(?<mimeType>[^\/]+\/[\w-]+)/i", $header, $match)) {
                return $match['mimeType'];
            }
        }
        return '';
    }
}
