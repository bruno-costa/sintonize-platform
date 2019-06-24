<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Radio;
use App\Models\Roles\RoleAdmin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DashUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
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
        $users = User::all();
        return view('adm.dash-user.all', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $radios = Radio::all();
        return view('adm.dash-user.create', compact('radios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'string',
                'avatar' => 'image|max:3000',
                'email' => 'email|unique:users',
                'password' => 'string|min:6',
                'isAdmin' => 'boolean',
                'radioId' => 'required_if:isAdmin,false|uuid|exists:radios,id'
            ]);

            $user = new User();
            $user->email = $data['email'];
            $user->name = $data['name'];
            $user->password = Hash::make($data['password']);

            DB::transaction(function () use ($user, $data) {
                $user->save();
                if ($data['isAdmin']) {
                    $user->adminRole()->create();
                } else {
                    $radio = Radio::findOrFail($data['radioId']);
                    $user->radios()->attach($radio->id);
                }
                if (isset($data['avatar'])) {
                    $avatarAsset = Asset::createLocalFromUploadedFile($data['avatar']);
                    $user->avatar()->associate($avatarAsset);
                    $user->save();
                }
            });
        } catch (ValidationException $e) {
            return response()->json([
                '_cod' => 'user-dash/create/validation',
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
            'userId' => $user->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Throwable $e) {
            return response()->json([
                '_cod' => 'user-dash/destroy/*',
                'errs' => [$e->getMessage()]
            ], 500);
        }

        return response()->json([
            '_cod' => 'ok',
        ]);
    }
}
