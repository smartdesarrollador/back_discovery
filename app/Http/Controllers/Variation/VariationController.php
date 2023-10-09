<?php

namespace App\Http\Controllers\Variation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Variation;
use Illuminate\Http\JsonResponse;


class VariationController extends ApiController
{
    public function index()
    {
        //
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $variation = Variation::create([
            'product_id' => $request->product_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'short_attribute_name' => $request->short_attribute_name
        ]);
        if ($variation) {
            return $this->successMessageResponse('Variacion creada correctamente');
        } else {
            return $this->errorResponse('No se pudo crear la variacion');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Variation $variation
     * @return JsonResponse
     */
    public function show(Variation $variation)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Variation $variation
     * @return \Illuminate\Http\Response
     */
    public function edit(Variation $variation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Variation $variation
     * @return JsonResponse
     */
    public function update(Request $request, Variation $variation)
    {
        $affectedRows = $variation->update([
            'short_attribute_name' => $request->short_attribute_name,
            'price' => $request->price,
            'stock' => $request->stock
        ]);
        return $this->successMessageResponse('Variación actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Variation $variation
     * @return JsonResponse
     */
    public function destroy(Variation $variation)
    {
        if ($variation->product->variations->count() < 2) {
            return $this->errorResponse('No puedes Borrar la unica existencia de este product', 400);
        }
        if ($variation->delete()) {
            return $this->successMessageResponse('Existencia Borrada correctamente');
        }
        return $this->errorResponse('Error al borrar variación', 400);


    }
}
