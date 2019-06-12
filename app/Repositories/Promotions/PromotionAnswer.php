<?php

namespace App\Repositories\Promotions;

use App\Models\AppUser;
use App\Models\ContentParticipation;

class PromotionAnswer extends PromotionAbstract
{

    public function getType(): string
    {
        return 'response';
    }

    public function dataJsonParticipations(AppUser $user): array
    {
        /** @var ContentParticipation $participation */
        $participation = $this->content->participations()->where('app_user_id', optional($user)->id)->first();
        $answer = null;
        if ($participation) {
            $answer = $participation->promotion_answer_array['answer'] ?? null;
        }
        return [
            'answer' => $answer
        ];
    }
}
