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

    /**
     * @param ContentParticipation $participation
     * @param array $data
     */
    public abstract function createParticipation(ContentParticipation $participation, array $data);

    public abstract function isParticipationCorrect(ContentParticipation $participation): bool;

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
        $participation->is_winner = $this->premium // se tem premio
            && $this->premium->isChronologic() // se é cronologico
            && (
                $this->premium->getValidAt() // se tem validade
                && date('Y-m-d') <= $this->premium->getValidAt() // ainda ta valido
            )
            && (
                $this->premium->getRewardAmount() // se tem limite de premios
                && $this->content->participations()->where('is_winner', true)->count() > $this->premium->getRewardAmount() // ainda tem premio
            )
            && (
                $this->premium->isRewardOnlyCorrect() &&
                $this->isParticipationCorrect($participation)
            );
        $participation->save();
    }

    public function dataJsonParticipations(AppUser $user): array
    {
        return [];
    }

    public function storeData(): array
    {
        return [
            '_class' => static::class,
            '_data' => $this->getArraySerialized(),
            '_common' => [
                'premium' => optional($this->premium)->toArray() ?? [],
            ],
        ];
    }

    static public function restoreData(array $data, Content $content): PromotionAbstract
    {
        /** @var PromotionAbstract $obj */
        $obj = new $data['_class']($content);
        $obj->setArraySerialized($data['_data']);
        $common = $data['_common'] ?? [];
        if (isset($common['premium']) && is_array($common['premium'])
            && isset($data['name'])
            && isset($data['rule'])
            && isset($data['validAt'])
            && isset($data['rewardAmount'])
            && isset($data['winMethod'])
            && isset($data['lotteryAt'])
            && isset($data['rewardOnlyCorrect'])
        ) {
            $obj->premium = new PremiumPromotion();
            $obj->premium
                ->setName($data['name'])
                ->setRule($data['rule'])
                ->setValidAt($data['validAt'])
                ->setRewardAmount($data['rewardAmount'])
                ->setWinMethod($data['winMethod'])
                ->setLotteryAt($data['lotteryAt'])
                ->setRewardOnlyCorrect($data['rewardOnlyCorrect']);
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
