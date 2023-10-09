<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends Controller
{
    public  $loginAfterSignUp = true;

    public  function  register(Request  $request) {
        $user = new  User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return  $this->login($request);
        }

        return  response()->json([
            'ok' => 'true',
            'usuario' => $user
        ], 200);
    }


    public  function  login(Request  $request) {
        $input = $request->only('email', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return  response()->json([
                'ok' => 'false',
                'message' => 'Correo o contraseña no válidos.',
            ], 401);
        }

        return  response()->json([
            'ok' => 'true',
            'token' => $jwt_token,
        ]);
    }

    public  function  logout(Request  $request) {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);
            return  response()->json([
                'ok' => 'true',
                'message' => 'Cierre de sesión exitoso.'
            ]);
        } catch (JWTException  $exception) {
            return  response()->json([
                'status' => 'unknown_error',
                'message' => 'Al usuario no se le pudo cerrar la sesión.'
            ], 500);
        }
    }

    public  function  getAuthUser(Request  $request) {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);
        return  response()->json(['user' => $user]);
    }
}
