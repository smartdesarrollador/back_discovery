<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;


class ProductImagesController extends ApiController
{
    public function index(Product $product)
    {


        return $this->showAll($product->productImages);
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
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Product $product)
    {
        request()->validate([

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $photoName = time() . '.' . $request->image->getClientOriginalExtension();


        $request->image->move(public_path('images/products'), $photoName);

        ProductImage::create([
            'product_id' => $product->id,
            'file_name' => $photoName
        ]);
        return $this->successMessageResponse('La imagen se cargó correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
    }

    public function deleteProductImage($id)
    {

        $productImage = ProductImage::findOrFail($id);


        if (!$productImage->delete()) {
            return $this->errorResponse('Error al Borrar Imagen', 400);
        }
        if (file_exists(public_path('images/products') . '/' . $productImage->file_name)) {

            unlink(public_path('images/products') . '/' . $productImage->file_name);
        }
        return $this->successMessageResponse('Borrado Correctamente');

    }
}
