<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var AppUser $user */
        $user = $request->user();
        $user->name = $request['name'];
        $user->gender = $request['gender'];
        $user->birthday = $request['birthday'];

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
}
