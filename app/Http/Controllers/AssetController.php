<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AssetController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $jwt)
    {
        if (is_null($jwt)) {
            return response()->json([
                '_cod' => 'asset/no-have-jwt'
            ], 404);
        }

        try {
            $payload = JWT::decode($jwt, env('APP_KEY'), ['HS256']);
            $asset = Asset::findOrFail($payload->asset_id);
        } catch (ExpiredException $e) {
            return response()->json([
                '_cod' => 'asset/expired-jwt'
            ], 410);
        } catch (\Throwable $e) {
            return response()->json([
                '_cod' => 'asset/not-allowed'
            ], 403);
        }

        return $this->generateResponse($asset, $payload->exp);
    }

    private function generateResponse(Asset $asset, $exp)
    {
        if ($asset->disk == 'local') {
            return response()->redirectTo(url($asset->path), 302, [
                'expires' => date('D, d M Y H:i:s \G\M\T', $exp),
                'last-modified'=> $asset->updated_at->toRfc7231String(),
            ]);
        }

        return response()->json([
            '_cod' => 'asset/unknown'
        ], 512);
    }

    public static function url(Asset $asset, $minExp = 60)
    {
        $payload = [
            'asset_id' => $asset->id,
            'exp' => \Carbon\Carbon::now()->addMinutes($minExp)->timestamp,
        ];
        $jwt = JWT::encode($payload, env('APP_KEY'), 'HS256');
        return route('asset', [$jwt]);
    }
}
