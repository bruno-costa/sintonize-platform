<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdvertiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $data = $request->validate([
                'name' => 'required|string',
                'avatar' => 'required|image|max:3000',
                'url' => 'nullable|url',
            ]);

            $avatarAsset = Asset::createLocalFromUploadedFile($data['avatar']);

            $advertiser = Advertiser::create([
                'name' => $data['name'],
                'avatar_asset_id' => $avatarAsset->id,
                'url' => $data['url'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                '_cod' => 'advertiser/create/validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                '_cod' => 'user-dash/create/*',
                'errs' => [$e->getMessage()]
            ], 500);
        }
        return response()->json([
            '_cod' => 'ok',
            'advertiserId' => $advertiser->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
