<?php

namespace App\Repositories;

class Option implements \Serializable
{
    /** @var string */
    public $label;
    /** @var bool */
    public $isCorrect;

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return json_encode($this);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $data = json_decode($serialized);
        $this->label = $data->label;
        $this->isCorrect = $data->isCorrect;
    }
}
