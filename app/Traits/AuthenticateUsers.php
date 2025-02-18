<?php
namespace App\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers as BaseAuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use Spatie\Permission\Models\Role;
trait AuthenticateUsers
{
    use BaseAuthenticatesUsers;

    /**
     * Manejar un intento de inicio de sesión para el usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {  
        $data = $request->only('email', 'password');
     

        if (!Auth::attempt($data)) {
        return response()->json([
            'ok' => false,
            'user' => 'Error de credenciales',
        ]);
        }

        return response()->json([
            'ok' => true,
            'user' => Auth::user(),
        ]);
    }

  public function Logout(){

     $this->guard()->logout();

    request()->session()->invalidate();

    return redirect('/');


    }


}