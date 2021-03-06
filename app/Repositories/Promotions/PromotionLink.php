<?php

namespace App\Repositories\Promotions;

use App\Models\AppUser;
use App\Models\ContentParticipation;

class PromotionLink extends PromotionAbstract
{
    public $label = '';
    public $url = '';

    static public function getType(): string
    {
        return 'link';
    }

    public function dataArrayPublic(): array
    {
        return [
            'label' => $this->label,
            'url' => $this->url,
        ];
    }

    protected function getArraySerialized(): array
    {
        return [
            'label' => $this->label,
            'url' => $this->url,
        ];
    }

    protected function setArraySerialized(array $data)
    {
        $this->label = $data['label'];
        $this->url = $data['url'];
    }

    /**
     * @param ContentParticipation $participation
     * @param array $data
     */
    public function createParticipation(ContentParticipation $participation, array $data)
    {
        $participation->promotion_answer_array = [];
        return null;
    }

    public function isParticipationCorrect(ContentParticipation $participation): bool
    {
        return true;
    }
}
