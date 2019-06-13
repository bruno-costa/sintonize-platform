<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\Content;
use Illuminate\Http\Request;

class RadioContentParticipateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($contentId, Request $request)
    {
        /** @var AppUser $user */
        $user = $request->user();
        $content = Content::find($contentId);

        if (!$content) {
            return response()->json([
                '_cod' => 'radio/content/not_found'
            ], 404);
        }

        $data = $request->toArray();

        $promotion = $content->promotion();

        try {
            $promotion->registerParticipation($data, $user);
        } catch (\Throwable $e) {
            return response()->json([
                '_cod' => 'fail'
            ], 400);
        }

        return response()->json([
            '_cod' => 'ok'
        ]);
    }
}
