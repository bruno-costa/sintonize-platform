<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use Illuminate\Http\Request;

class UserAppParticipationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var AppUser $user */
        $user = $request->user();
        $participations = $user->participations;
        $participations->load('content');
        $response = [];

        $resource = new RadioContentController();

        foreach ($participations as $participation) {
            $content = $participation->content;
            $response[] = $resource->generateResource($content, $participation);
        }

        return response()->json([
            '_cod' => 'ok',
            'participations' => $response
        ]);
    }
}
