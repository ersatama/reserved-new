<?php

namespace App\Http\Middleware;

use App\Domain\Contracts\UserContract;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BlockedUser
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
            if (backpack_auth()->user()->blocked === UserContract::TRANSLATE[UserContract::OFF] && Route::currentRouteName() !== 'user.blocked' && Route::currentRouteName() !== 'exit') {
                return redirect()->route('user.blocked');
            } elseif (backpack_auth()->user()->blocked === UserContract::TRANSLATE[UserContract::ON] && Route::currentRouteName() === 'user.blocked') {
                return redirect('admin/dashboard');
            }
        } elseif (Route::currentRouteName() === 'user.blocked') {
            return redirect('admin/login');
        }
        return $next($request);
    }
}
