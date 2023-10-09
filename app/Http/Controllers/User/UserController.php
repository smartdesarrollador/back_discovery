<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
     public function index()
    {
        return $this->showAll(User::all()->sortByDesc('created_at')->values());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $email
     * @return JsonResponse
     */
    public function checkByEmail($email)
    {
        $user = User::where('email', '=', $email)->first();
        if ($user === null) {
            return $this->successMessageResponse('El usuario no esta registrado');
        } else {

            return $this->errorResponse('El usuario ya se encuentra registrado', 200);
        }
    }

    /**
     * @param $email
     * @param $token
     * @return JsonResponse
     */
    public function checkByRecoveryTokenAndEmail($email, $token)
    {

        $user = User::where('email', '=', $email)->where('recovery_token', '=', $token)
            ->first();
        if ($user === null) {
            return $this->errorResponse('Token Incorrecto', 401);
        } else {

            return $this->successMessageResponse('Verificado correctamente', 200);
        }
    }

    /**
     * @param $email
     * @return JsonResponse
     */
    public function addRecoveryToken($email)
    {
        $token = uniqid();
        $affectedRows = User::where('email', $email)->update(['first_name' => 'Updated name', 'recovery_token' => $token]);

        $url = Config::get('values.reset_password_url') . '/reset-password/' . $email . '-' . $token;

        if ($affectedRows < 1) {
            return $this->errorResponse('El usuario no esta registrado', 404);
        }
        Mail::to($email)->send(new ResetPassword($url));

        return $this->successMessageResponse('Mensaje de recuperación enviado correctamente');


    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePassword(Request $request)
    {
        if (strlen($request->token) < 1) {
            return $this->errorResponse('Error al cambiar la contraseña, verifique los datos proporcionados1', 404);
        }
        $affectedRows = User::where('email', $request->email)
            ->where('recovery_token', '=', $request->token)
            ->update(['password' => bcrypt($request->password), 'recovery_token' => null]);

        if ($affectedRows < 1) {
            return $this->errorResponse('Error al cambiar la contraseña, verifique los datos proporcionados', 404);
        }

        return $this->successMessageResponse('Contraseña cambiada correctamente');


    }
}
