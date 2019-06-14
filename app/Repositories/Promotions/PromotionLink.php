<?php

namespace App\Repositories\Promotions;

use App\Models\AppUser;

class PromotionLink extends PromotionAbstract
{
    public $label = '';
    public $url = '';

    static public function getType(): string
    {
        return 'link';
    }

    public function dataJsonParticipations(AppUser $user): array
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
}
