<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;
use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Variation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends ApiController
{
     public function index()
    {
        $products = Product::all()->sortBy('name')->values();
        return $this->showAll($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $variations = json_decode($request->variations);
        if (count($variations) <= 0) {
            return $this->errorResponse('Se necesita una variación para crear el producto', 400);
        }
        return DB::transaction(function () use ($variations, $request) {
            $productIns = Product::create(
                [
                    'name' => $request->name,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'long_description' => $request->long_description,
                    'nutritional_description' => $request->nutritional_description,
                    'guide_description' => $request->guide_description,
                    'brand_id' => 1,
                    'relevance' => 0,
                ]
            );
            foreach ($variations as $variation) {
                Variation::create([
                    'product_id' => $productIns->id,
                    'price' => (float)$variation->price,
                    'stock' => (float)$variation->stock,
                    'short_attribute_name' => $variation->short_attribute_name
                ]);
            }
            foreach ($request->images as $key => $image) {
                $fileName = uniqid() . $key . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $fileName);
                ProductImage::create([
                    'product_id' => $productIns->id,
                    'file_name' => $fileName
                ]);
            }
            return $this->showOne($productIns);
        });

    }

    /**
     * Display the specified Product.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {

        $producto = $product->toArray();
        $brand = Brand::find($producto['brand_id'])->toArray();
        $images = ProductImage::all()->where('product_id', '=', $producto['id'])->values();

        $producto['brand'] = $brand;
        $producto['product_images'] = $images;
        return $this->showArray($producto);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return void
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        $affectedRows = $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'guide_description' => $request->guide_description,
            'long_description' => $request->long_description,
            'nutritional_description' => $request->nutritional_description,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return $this->successMessageResponse('Producto eliminado correctamente');
        } catch (\Exception $e) {
            return $this->errorResponse('El producto ya a sido elminado o no se encuentra', '404');

        }
    }

    public function searchProduct($param)
    {

        $query = trim(mb_strtolower($param, 'UTF-8'));
        $products = Product::where([
            ['name', 'LIKE', '%' . $query . '%']
        ])->get();


        $arrayProducts = [];
        foreach ($products as $product) {
            if (count($product->variations) > 0) {
                if ($product->stock > 0) {
                    array_push($arrayProducts, $product);

                }
            }
        }

        return $this->showArray($arrayProducts);


    }

    /*
    * random products
    * */

    public function getRandomProducts($qty)
    {
        $products = Product::all()->random($qty);

        $arrayProducts = [];
        foreach ($products as $product) {
            if (count($product->variations) > 0) {
                if ($product->stock > 0) {
                    array_push($arrayProducts, $product);

                }
            }
        }
        return $this->showArray($arrayProducts);
    }
}
