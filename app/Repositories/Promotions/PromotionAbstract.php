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

    public abstract function dataArrayPublic(): array;

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
                !$this->premium->getValidAt() // se não tem validade
                || date('Y-m-d') <= $this->premium->getValidAt() // ou ainda ta valido
            )
            && (
                !$this->premium->getRewardAmount() // se não tem limite de premios
                || $this->content->participations()->where('is_winner', true)->count() > $this->premium->getRewardAmount() // ou ainda tem premio
            )
            && (
                !$this->premium->isRewardOnlyCorrect() // se não apenas respostas corretas
                || $this->isParticipationCorrect($participation) // ou resposta esta correta
            );
        $participation->save();
    }

    public function storeData(): array
    {
        return [
            '_class' => static::class,
            '_data' => $this->getArraySerialized(),
            '_static' => [
                'premium' => optional($this->premium)->toArray() ?? [],
            ],
        ];
    }

    static public function restoreData(array $data, Content $content): PromotionAbstract
    {
        /** @var PromotionAbstract $obj */
        $obj = new $data['_class']($content);
        $obj->setArraySerialized($data['_data']);
        $common = $data['_static'] ?? [];
        if (isset($common['premium']) && is_array($common['premium'])
            && isset($common['premium']['name'])
            && isset($common['premium']['rule'])
            && isset($common['premium']['winMethod'])
            && isset($common['premium']['rewardOnlyCorrect'])
        ) {
            $obj->premium = new PremiumPromotion();
            $obj->premium
                ->setName($common['premium']['name'])
                ->setRule($common['premium']['rule'])
                ->setValidAt($common['premium']['validAt'] ?? null)
                ->setRewardAmount($common['premium']['rewardAmount'] ?? null)
                ->setWinMethod($common['premium']['winMethod'])
                ->setLotteryAt($common['premium']['lotteryAt'] ?? null)
                ->setRewardOnlyCorrect($common['premium']['rewardOnlyCorrect']);
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
