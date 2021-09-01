<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domain\Contracts\UserContract;
use Illuminate\Support\Facades\Route;

class SmsVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (backpack_auth()->check()) {

            if ((backpack_auth()->user()->phone_verified_at === UserContract::TRANSLATE['NOT_VERIFIED']) && Route::currentRouteName() !== 'phone.verify' && Route::currentRouteName() !== 'phone.code') {
                return redirect()->route('phone.verify');
            } elseif ((backpack_auth()->user()->phone_verified_at !== UserContract::TRANSLATE['NOT_VERIFIED']) && (Route::currentRouteName() === 'phone.verify' || Route::currentRouteName() === 'phone.code')) {
                return redirect('admin/dashboard');
            }
        }
        return $next($request);
    }
}
