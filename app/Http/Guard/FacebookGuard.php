<?php

namespace App\Http\Guard;

use App\Models\AppUser;
use Illuminate\Http\Request;

class FacebookGuard
{
    public function user(Request $request): ?AppUser
    {
        try {
            $responseData = $this->getFacebookData($request);
            $id = $responseData['id'];
            if ($id == null) {
                throw new \InvalidArgumentException("token invalid");
            }
            /** @var AppUser $user */
            $user = AppUser::where('facebook_id', $id)->firstOrNew([
                'phone_number' => $responseData['phone']['number'],
                'facebook_id' => $id
            ]);
            return $user;
        } catch (\Throwable $t) {
            return null;
        }
    }

    public function getFacebookData(Request $request)
    {
        $token = $request->bearerToken();
        try {
            $facebookResponse = file_get_contents('https://graph.accountkit.com/v1.0/me?access_token=' . $token);
            $responseData = json_decode($facebookResponse, true);
            return $responseData;
        } catch (\Throwable $t) {
            return [];
        }
    }
}
