<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpInvalidArgument;
use App\Models\AppUser;
use App\Models\Content;
use Illuminate\Http\Request;

class RadioContentParticipateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
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
        } catch (HttpInvalidArgument $e) {
            return response()->json([
                '_cod' => 'radio/content/' . $e->responseCod,
            ], 400);
        } catch (\Throwable $e) {
            return response()->json([
                '_cod' => 'fail',
                'exception' => [
                    'msg' => $e->getMessage(),
                    //'trace' => $e->getTrace()
                ]
            ], 400);
        }

        return response()->json([
            '_cod' => 'ok'
        ]);
    }
}
