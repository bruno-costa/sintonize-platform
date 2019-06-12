<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Radio;
use Illuminate\Http\Request;

class RadioContentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $radio = Radio::with('contents')->find($id);
        if (!$radio) {
            return response()->json([
                '_cod' => 'radio/show/not_found'
            ], 404);
        }

        return response()->json([
            '_cod' => 'ok',
            'contents' => $radio->contents->map(function(Content $content) {
                return [
                    'id' => $content->id,
                    'postedAt' => $content->created_at,
                    'text' => $content->text,
                    'imageUrl' => $content->imageUrl(),
                    'advertiser' => null,
                    'rulesText' => $content->rulesText(),
                    'action' => $content->promotion(),
                    'winCode' => $content->winCode(),
                ];
            })
        ]);
    }
}
