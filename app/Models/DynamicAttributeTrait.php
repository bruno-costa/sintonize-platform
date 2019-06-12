<?php

namespace App\Models;

trait DynamicAttributeTrait
{

    protected function dynamicAttributeMutator(string $prop, array $args)
    {
        $data = $this->{$this->dynamicAttributeProp} ?? [];
        if (count($args) === 0) {
            return $data[$prop] ?? null;
        } else {
            $this->{$this->dynamicAttributeProp} = [
                    $prop => $args[0],
                ] + $data;
            return $args[0];
        }
    }
}
