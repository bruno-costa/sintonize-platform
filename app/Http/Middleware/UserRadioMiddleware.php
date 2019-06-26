<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class UserRadioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var \App\User $user */
        try {
            $user = $request->user();
            $this->handleSession($user);
        } catch (\Throwable $t) {
            return redirect()->action('Auth\LoginController@blockLogout');
        }
        return $next($request);
    }

    static public function handleSession(User $user)
    {
        if ($user->isAdmin()) {
            session()->remove('radio_id');
        } else if (!session()->exists('radio_id')) {
            session()->put('radio_id', $user->radios()->firstOrFail()->id);
        }
    }
}
