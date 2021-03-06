<?php

namespace App\Repositories\Promotions;

use App\Exceptions\HttpInvalidArgument;
use App\Models\AppUser;
use App\Models\ContentParticipation;

class PromotionAnswer extends PromotionAbstract
{
    public $label = '';
    static public function getType(): string
    {
        return 'response';
    }

    public function dataArrayPublic(): array
    {
        return [
            'label' => $this->label
        ];
    }

    protected function getArraySerialized(): array
    {
        return [
            'label' => $this->label,
        ];
    }

    protected function setArraySerialized(array $data)
    {
        $this->label = $data['label'] ?? null;
    }

    /**
     * @throws HttpInvalidArgument
     * @param ContentParticipation $participation
     * @param array $data
     */
    public function createParticipation(ContentParticipation $participation, array $data)
    {
        // validar
        if (!isset($data['response'])) {
            throw new HttpInvalidArgument("response_missing");
        }

        $response = $data['response'];

        $participation->promotion_answer_array = [
            'answer' => $response
        ];
    }

    public function isParticipationCorrect(ContentParticipation $participation): bool
    {
        return true;
    }
}
