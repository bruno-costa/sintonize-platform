<?php

namespace App\Exceptions;

use \Exception;
use Throwable;

class HttpInvalidArgument extends Exception
{
    public $responseCod;

    public function __construct(string $responseCod, string $message = "", Throwable $previous = null)
    {
        $this->responseCod = $responseCod;
        parent::__construct($message, 0, $previous);
    }
}
