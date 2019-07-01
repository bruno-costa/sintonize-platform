<?php

namespace App\Repositories\Promotions;

use App\Models\ContentParticipation;

class PromotionVoucher extends PromotionAbstract
{
    public $label;

    static public function getType(): string
    {
        return 'voucher';
    }

    protected function getArraySerialized(): array
    {
        return [
            'label' => $this->label
        ];
    }

    protected function setArraySerialized(array $data)
    {
        $this->label = $data['label'];
    }

    public function dataArrayPublic(): array
    {
        return [
            'label' => $this->label
        ];
    }

    /**
     * @param ContentParticipation $participation
     * @param array $data
     */
    public function createParticipation(ContentParticipation $participation, array $data)
    {
        $participation->promotion_answer_array = [];
    }

    public function isParticipationCorrect(ContentParticipation $participation): bool
    {
        return true;
    }
}
