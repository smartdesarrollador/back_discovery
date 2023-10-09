<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Models\Store;
use Illuminate\Http\JsonResponse;


class StoreController extends ApiController
{
    public function index(Store $store)
    {
        //
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
     * @param \App\Store $store
     * @return JsonResponse
     */
    public function show(Store $store)
    {
        return $this->showOne($store);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Store $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Store $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {

        $store->update([
            'min_value_free_shipping' => $request->min_value_free_shipping != null ? $request->min_value_free_shipping : $store->min_value_free_shipping,
            'exchange_rate' => $request->exchange_rate != null ? $request->exchange_rate : $store->exchange_rate
        ]);

        return $this->successMessageResponse('ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Store $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
