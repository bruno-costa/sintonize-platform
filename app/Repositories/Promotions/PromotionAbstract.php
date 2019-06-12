<?php

namespace App\Repositories\Promotions;

abstract class PromotionAbstract implements \JsonSerializable, \Serializable
{
    abstract public function getType(): string;

    abstract protected function getArraySerialized(): array;

    abstract protected function setArraySerialized(array $data);

    protected function dataJson(): array
    {
        return $this->getArraySerialized();
    }

    public function jsonSerialize()
    {

        return ['type' => $this->getType()] + $this->dataJson();
    }

    public function serialize()
    {
        return json_encode($this->getArraySerialized());
    }

    public function unserialize($serialized)
    {
        $this->setArraySerialized(json_decode($serialized, true));
    }

    public function storeData(): array
    {
        return [
            '_class' => static::class,
            '_data' => $this->getArraySerialized()
        ];
    }

    static public function restoreData(array $data): PromotionAbstract
    {
        /** @var PromotionAbstract $obj */
        $obj = new $data['_class'];
        $obj->setArraySerialized($data['_data']);
        return $obj;
    }
}
