<?php

namespace App\Utils;

class Validator
{
    /** @var bool */
    private $isValid = false;
    /** @var string */
    private $message = '';

    /**
     * Validator constructor.
     * @param bool $isValid
     * @param string $message
     */
    public function __construct(bool $isValid, string $message)
    {
        $this->isValid = $isValid;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
