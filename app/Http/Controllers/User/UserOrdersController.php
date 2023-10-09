<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;

class UserOrdersController extends ApiController
{
    public function index(Request $request, User $user)
    {


        /*$authenticatedUser = JWTAuth::authenticate($request->bearerToken());


        if ($user->id != $authenticatedUser->id) {
            return $this->errorResponse('No esta autorizado para cambiar los datos de este usuario', 401);
        }



        return $this->showAll(Order::all()->where('user_id', '=', $authenticatedUser->id)) ;*/

        $orders = $user->orders()->latest()->get();
        return $this->showAll($orders);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
