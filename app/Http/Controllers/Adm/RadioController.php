<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Asset;
use App\Models\Radio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RadioController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            /**
             * @var Request $request
             * @var \Closure $next
             * @var User $user
             */
            $user = $request->user();
            if ($user->isAdmin()) {
                return $next($request);
            } else {
                if ($request->expectsJson()) {
                    return response()->json([
                        '_cod' => 'radio/unauthorized'
                    ], 401);
                } else {
                    return abort(401);
                }
            }
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $radios = Radio::with('contents')->orderByDesc('updated_at')->get();
        return view('adm.radio.all', compact('radios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.radio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validar cor
        preg_match('/#[0-9A-F]{6}/', strtoupper($request->post('themeColor', '')), $output_array);
        $color = $output_array[0] ?? null;
        if (!$color) {
            return response()->json([
                '_cod' => 'radio/create/invalid_color'
            ], 400);
        }

        // validar asset
        $a = Asset::createLocalFromUploadedFile($request->file('avatar'));
        if (strpos($a->mime_type, 'image/') !== 0) {
            $a->delete();
            return response()->json([
                '_cod' => 'radio/create/invalid_avatar/mimetype'
            ], 400);
        }
        if ($a->size > 3000000) {
            $a->delete();
            return response()->json([
                '_cod' => 'radio/create/invalid_avatar/size'
            ], 400);
        }

        // validando a streamUrl
        $streamUrl = filter_var($request->post('streamUrl'), FILTER_VALIDATE_URL);
        if (!$streamUrl) {
            return response()->json([
                '_cod' => 'radio/create/invalid_stream_url'
            ], 400);
        }

        $r = new \App\Models\Radio();
        $r->id = Str::uuid();
        $r->avatar_asset_id = $a->id;
        $r->name = $request->post('name');
        $r->description = '';
        $r->city = '';
        $r->estate = '';
        $r->themeColor($color);
        $r->streamUrl($streamUrl);
        $r->save();

        return response()->json([
            '_cod' => 'ok',
            'radio_id' => $r->id
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
