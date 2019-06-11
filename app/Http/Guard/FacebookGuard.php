<?php

namespace App\Http\Guard;

use App\Models\AppUser;
use Illuminate\Http\Request;

class FacebookGuard
{
    public function user(Request $request): ?AppUser
    {
        $token = $request['auth_token'] ?? null;
        try {
            $facebookResponse = file_get_contents('https://graph.accountkit.com/v1.0/me?access_token=' . $token);
            $responseData = json_decode($facebookResponse, true);
            $id = $responseData['id'];
            if ($id == null) {
                throw new \InvalidArgumentException("token invalid");
            }
            /** @var AppUser $user */
            $user = AppUser::where('facebook_id', $id)->firstOrCreate([
                'phone_number' => $responseData['phone']['number'],
                'facebook_id' => $id
            ]);
            return $user;
        } catch (\Throwable $t) {
            return null;
        }
    }
}
