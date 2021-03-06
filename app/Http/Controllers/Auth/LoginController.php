<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\UserRadioMiddleware;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'blockLogout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        /** @var \App\User $user */
        try {
            UserRadioMiddleware::handleSession($user);
        } catch (\Throwable $t) {
            return redirect()->action('Auth\LoginController@blockLogout');
        }
        return redirect()->route('home');
    }

    public function blockLogout(Request $request)
    {
        $userId = optional($request->user())->id;

        $request->session()->invalidate();
        $request->session()->put('user_id', $userId);

        $this->guard()->logout();

        return redirect()->route('login');
    }
}
