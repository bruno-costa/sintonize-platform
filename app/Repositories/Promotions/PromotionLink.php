<?php

namespace App\Repositories\Promotions;

class PromotionLink extends PromotionAbstract
{
    public $label = '';
    public $url = '';

    public function getType(): string
    {
        return 'link';
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
