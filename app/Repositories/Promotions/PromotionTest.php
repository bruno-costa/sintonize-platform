<?php

namespace App\Repositories\Promotions;

use App\Models\AppUser;
use App\Models\ContentParticipation;
use App\Repositories\Option;
use Illuminate\Support\Collection;

class PromotionTest extends PromotionAbstract
{
    /** @var Option[]|Collection */
    public $options;

    static public function getType(): string
    {
        return 'test';
    }

    protected function getArraySerialized(): array
    {
        return [
            'options' => $this->options->map([function (Option $option) {
                return $option->serialize();
            }])
        ];
    }

    protected function setArraySerialized(array $data)
    {
        $this->options = collect($data['options'])->map(function ($serial) {
            $option = new Option();
            $option->unserialize($serial);
            return $option;
        });
    }

    public function createParticipation(ContentParticipation $participation, array $data)
    {
        $participation->is_winner = false;
        $participation->promotion_answer_array = ['choice' => $data['choice']];
    }

    public function dataJsonParticipations(AppUser $user): array
    {
        /** @var ContentParticipation $participation */
        $participation = $this->content->participations()->where('app_user_id', optional($user)->id)->first();
        $choice = null;
        if ($participation) {
            $choice = $participation->promotion_answer_array['choice'] ?? null;
        }
        return [
            'choice' => $choice,
            'options' => $this->loadOptionsPercents()
        ];
    }

    private function loadOptionsPercents()
    {
        return collect($this->options)->map(function (Option $option) {
            return [
                'label' => $option->label,
                'percent' => '0',
                'isCorrect' => $option->isCorrect,
            ];
        });
    }
}
