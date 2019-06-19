<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\Content;
use App\Models\Radio;
use Illuminate\Http\Request;

class RadioContentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        /** @var AppUser $user */
        $user = $request->user();
        $radio = Radio::with('contents')->find($id);

        if (!$radio) {
            return response()->json([
                '_cod' => 'radio/show/not_found'
            ], 404);
        }

        return response()->json([
            '_cod' => 'ok',
            'contents' => $radio->contents->map(function (Content $content) use ($user) {
                return [
                    'id' => $content->id,
                    'postedAt' => $content->created_at,
                    'text' => $content->text,
                    'imageUrl' => $content->imageUrl(),
                    'advertiser' => $this->getAdvertiser($content),
                    'rulesText' => $content->rulesText(),
                    'action' => $this->getContentAction($content, $user),
                    'winCode' => $content->winCode(),
                ];
            })
        ]);
    }

    public function getContentAction(Content $content, AppUser $user)
    {
        $promotion = $content->promotion();
        if ($promotion) {
            $type = [
                'type' => $promotion->getType()
            ];
            return $type + $promotion->dataJsonParticipations($user);
        }
        return null;
    }

    public function getAdvertiser(Content $content)
    {
        $advertiser = null;
        return $advertiser ? [
            'name' => '',
            'imageUrl' => '',
            'url' => '',
        ] : null;
    }
}
