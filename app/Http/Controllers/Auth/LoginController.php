<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AuthenticateUsers;

class LoginController extends Controller
{
    use AuthenticateUsers; 

    protected $redirectTo = '/home'; 

    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    } 

}
