<?php

namespace App\Http\Controllers\ProductFeatures;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\ProductFeatures;
use App\Models\Variation;
use Illuminate\Http\JsonResponse;

class ProductFeaturesController extends ApiController
{
     public function index(Variation $variation)
    {
        return $this->showAll($variation->productFeatures);
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
     * @param \App\ProductFeatures $productFeatures
     * @return \Illuminate\Http\Response
     */
    public function show(ProductFeaturesController $productFeatures)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ProductFeatures $productFeatures
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductFeaturesController $productFeatures)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ProductFeatures $productFeatures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductFeaturesController $productFeatures)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ProductFeatures $productFeatures
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductFeaturesController $productFeatures)
    {
        //
    }
}
