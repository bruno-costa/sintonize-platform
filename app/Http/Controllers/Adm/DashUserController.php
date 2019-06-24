<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DashUserController extends Controller
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
        return view('adm.dash-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
