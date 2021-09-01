<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\Auth\LoginController as BackPackLoginController;

class LoginController extends BackPackLoginController
{
    public function logout(Request $request)
    {
        $this->guard()->logout();
        return redirect('admin/login');
    }
}
