<?php

namespace App\Repositories\Promotions;

use App\Exceptions\HttpInvalidArgument;
use App\Models\AppUser;
use App\Models\ContentParticipation;
use App\Repositories\Option;
use Illuminate\Support\Collection;

class PromotionTest extends PromotionAbstract
{
    /** @var Option[]|Collection */
    public $options;

    protected function boot()
    {
        $this->options = new Collection();
    }

    public function addRawOption(string $label, bool $isCorrect = false)
    {
        $option = new Option();
        $option->label = $label;
        $option->isCorrect = $isCorrect;
        return $this->addOption($option);
    }

    public function addOption(Option $option)
    {
        $this->options->push($option);
    }

    static public function getType(): string
    {
        return 'test';
    }

    protected function getArraySerialized(): array
    {
        return [
            'options' => $this->options->map(function (Option $option) {
                return $option->serialize();
            })
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

    /**
     * @param ContentParticipation $participation
     * @param array $data
     * @throws HttpInvalidArgument
     */
    public function createParticipation(ContentParticipation $participation, array $data)
    {
        // validar
        if (!isset($data['choice'])) {
            throw new HttpInvalidArgument("choice_missing");
        }
        $choice = $data['choice'];

        if (!isset($this->options[$choice])) {
            throw new HttpInvalidArgument("choice_invalid");
        }

        $participation->is_winner = false;
        $participation->promotion_answer_array = [
            'choice' => $choice
        ];
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
