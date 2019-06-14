<?php

namespace App\Http\Controllers;

use App\Models\Radio;
use Illuminate\Http\Request;

class RadioListController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $radios = Radio::with('avatar')->get();
        return response()->json([
            '_cod' => 'ok',
            'radios' => $radios->map(function(Radio $radio) {
                return [
                    'id' => $radio->id,
                    'name' => $radio->name,
                    'themeColor' => $radio->themeColor(),
                    'avatarUrl' => $radio->avatarUrl(),
                    'streamUrl' => $radio->streamUrl(),
                    'station' => $radio->station()
                ];
            })->values()->toArray(),
        ]);
    }
}
