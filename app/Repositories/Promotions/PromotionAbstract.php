<?php

namespace App\Repositories\Promotions;

use App\Models\AppUser;
use App\Models\Content;
use App\Models\ContentParticipation;

abstract class PromotionAbstract implements \Serializable
{
    /** @var Content */
    protected $content;

    static abstract public function getType(): string;

    public function createParticipation(ContentParticipation $participation, array $data)
    {
        $participation->is_winner = false;
        $participation->promotion_answer_array = [];
    }

    final public function __construct(Content $content)
    {
        $this->content = $content;
        $this->boot();
    }

    protected function boot()
    {
    }

    public function registerParticipation(array $data, AppUser $user)
    {
        $participation = ContentParticipation::whereContentId($this->content->id)
            ->whereAppUserId($user->id)
            ->firstOrNew([
                'app_user_id' => $user->id,
                'content_id' => $this->content->id,
            ]);
        $this->createParticipation($participation, $data);
        $participation->save();
    }

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
