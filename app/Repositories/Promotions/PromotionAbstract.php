<?php

namespace App\Repositories\Promotions;

use App\Models\AppUser;
use App\Models\Content;

abstract class PromotionAbstract implements \Serializable
{
    /** @var Content */
    protected $content;

    final public function __construct(Content $content)
    {
        $this->content = $content;
    }

    abstract public function getType(): string;

    protected function getArraySerialized(): array
    {
        return [];
    }

    protected function setArraySerialized(array $data)
    {
    }

    public function dataJsonParticipations(AppUser $user): array
    {
        return [];
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

    static public function restoreData(array $data, Content $content): PromotionAbstract
    {
        /** @var PromotionAbstract $obj */
        $obj = new $data['_class']($content);
        $obj->setArraySerialized($data['_data']);
        return $obj;
    }
}
