<?php

namespace App\Repositories;

use Illuminate\Support\Carbon;

class PremiumPromotion
{
    /** @var string */
    private $name;

    /** @var string */
    private $rule;

    /** @var string date in format Y-m-d */
    private $validAt;

    /** @var int|null greter then 1 */
    private $rewardAmount;

    /** @var string option in "lottery", "chronologic" */
    private $winMethod;

    /** @var string|null date in format Y-m-d */
    private $lotteryAt;

    /** @var bool */
    private $rewardOnlyCorrect = false;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'rule' => $this->rule,
            'validAt' => $this->validAt,
            'rewardAmount' => $this->rewardAmount,
            'winMethod' => $this->winMethod,
            'lotteryAt' => $this->lotteryAt,
            'rewardOnlyCorrect' => $this->rewardOnlyCorrect,
        ];
    }

    public function isLottery(): bool
    {
        return $this->winMethod == 'lottery';
    }

    public function isChronologic(): bool
    {
        return $this->winMethod == 'chronologic';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PremiumPromotion
     */
    public function setName(string $name): PremiumPromotion
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getRule(): string
    {
        return $this->rule;
    }

    /**
     * @param string $rule
     * @return PremiumPromotion
     */
    public function setRule(string $rule): PremiumPromotion
    {
        $this->rule = $rule;
        return $this;
    }

    /**
     * @return string
     */
    public function getValidAt(): string
    {
        return $this->validAt;
    }

    /**
     * @param string $validAt
     * @return PremiumPromotion
     */
    public function setValidAt(string $validAt): PremiumPromotion
    {
        if (Carbon::createFromFormat('Y-m-d', $validAt)->format('Y-m-d') != $validAt) {
            throw new \UnexpectedValueException("invalid date format, expected \"Y-m-d\"");
        }
        $this->validAt = $validAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRewardAmount(): ?int
    {
        return $this->rewardAmount;
    }

    /**
     * @param int|null $rewardAmount
     * @return PremiumPromotion
     */
    public function setRewardAmount(?int $rewardAmount): PremiumPromotion
    {
        $this->rewardAmount = $rewardAmount;
        return $this;
    }

    /**
     * @return string
     */
    public function getWinMethod(): string
    {
        return $this->winMethod;
    }

    /**
     * @param string $rawWinMethod
     * @return PremiumPromotion
     */
    public function setWinMethod(string $rawWinMethod): PremiumPromotion
    {
        $winMethod = strtolower($rawWinMethod);
        if (!in_array($winMethod, ["lottery", "chronologic"])) {
            throw new \UnexpectedValueException("invalid win method, expected \"lottery\", \"chronologic\", got \"{$winMethod}\"");
        }
        $this->winMethod = $winMethod;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLotteryAt(): ?string
    {
        return $this->lotteryAt;
    }

    /**
     * @param null|string $lotteryAt
     * @return PremiumPromotion
     */
    public function setLotteryAt(?string $lotteryAt): PremiumPromotion
    {
        if ($lotteryAt && Carbon::createFromFormat('Y-m-d', $lotteryAt)->format('Y-m-d') != $lotteryAt) {
            throw new \UnexpectedValueException("invalid date format, expected \"Y-m-d\"");
        }
        $this->lotteryAt = $lotteryAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRewardOnlyCorrect(): bool
    {
        return $this->rewardOnlyCorrect;
    }

    /**
     * @param bool $rewardOnlyCorrect
     * @return PremiumPromotion
     */
    public function setRewardOnlyCorrect(bool $rewardOnlyCorrect): PremiumPromotion
    {
        $this->rewardOnlyCorrect = $rewardOnlyCorrect;
        return $this;
    }
}
