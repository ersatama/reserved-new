<?php

namespace App\Http\Middleware;

use App\Domain\Contracts\UserContract;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if (backpack_auth()->check()) {
            if (backpack_auth()->user()->role === UserContract::TRANSLATE[UserContract::ADMINISTRATOR] || backpack_auth()->user()->role === UserContract::TRANSLATE[UserContract::MODERATOR] && Route::currentRouteName() !== 'exit') {
                return $next($request);
            } elseif (Route::currentRouteName() !== 'user.restricted' && Route::currentRouteName() !== 'exit') {
                return redirect()->route('user.restricted');
            }
        } elseif (Route::currentRouteName() === 'user.restricted') {
            return redirect('admin/login');
        }
        return $next($request);
    }
}
