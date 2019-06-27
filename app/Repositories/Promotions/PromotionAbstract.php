<?php

namespace App\Repositories\Promotions;

use App\Models\AppUser;
use App\Models\Content;
use App\Models\ContentParticipation;
use App\Repositories\PremiumPromotion;

abstract class PromotionAbstract
{
    /** @var Content */
    protected $content;
    /** @var PremiumPromotion|null */
    protected $premium;

    static abstract public function getType(): string;
    protected abstract function getArraySerialized(): array;
    protected abstract function setArraySerialized(array $data);

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
        // pass
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

    public function dataJsonParticipations(AppUser $user): array
    {
        return [];
    }

    public function createPremium(array $data)
    {
        $this->premium = new PremiumPromotion();
        $this->premium
            ->setName($data['premiumName'] ?? $data['name'] ?? null)
            ->setRule($data['premiumRule'] ?? $data['rule'] ?? null)
            ->setValidAt($data['premiumValidAt'] ?? $data['validAt'] ?? null)
            ->setRewardAmount($data['premiumRewardAmount'] ?? $data['rewardAmount'] ?? null)
            ->setWinMethod($data['premiumWinMethod'] ?? $data['winMethod'] ?? null)
            ->setLotteryAt($data['premiumLotteryAt'] ?? $data['lotteryAt'] ?? null);
    }

    public function storeData(): array
    {
        return [
            '_class' => static::class,
            '_data' => $this->getArraySerialized(),
            '_common' => [
                'premium' => optional($this->premium)->toArray(),
            ],
        ];
    }

    static public function restoreData(array $data, Content $content): PromotionAbstract
    {
        /** @var PromotionAbstract $obj */
        $obj = new $data['_class']($content);
        $obj->setArraySerialized($data['_data']);
        $common = $data['_common'] ?? [];
        if (isset($common['premium'])) {
            $obj->createPremium($common['premium']);
        }
        return $obj;
    }

    /**
     * @return PremiumPromotion|null
     */
    public function getPremium(): ?PremiumPromotion
    {
        return $this->premium;
    }

    /**
     * @param PremiumPromotion|null $premium
     * @return PromotionAbstract
     */
    public function setPremium(?PremiumPromotion $premium): PromotionAbstract
    {
        $this->premium = $premium;
        return $this;
    }
}
