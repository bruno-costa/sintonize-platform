<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Guard\FacebookGuard;
use Illuminate\Http\Request;

class AppAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = app(FacebookGuard::class)->user($request);
        if ($user === null) {
            return response()->json([
                '_cod' => 'auth/token_invalid'
            ], 400);
        }

        if ($user->exists) {
            return response()->json([
                '_cod' => 'ok',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phoneNumber' => $user->phone_number,
                    'gender' => $user->gender,
                    'birthday' => $user->birthday,
                ]
            ]);
        }

        return response()->json([
            '_cod' => 'auth/new_user'
        ]);
    }
}
