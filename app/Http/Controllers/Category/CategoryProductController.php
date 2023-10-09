<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\JsonResponse;


class CategoryProductController extends ApiController
{


    public function index(Category $category)
    {

        $products = Product::where('category_id', '=', $category->id)->orderBy('relevance', 'DESC')->get();

        $arrayProducts = [];
        foreach ($products as $product) {
            if (count($product->variations) > 0) {
                if ($product->stock > 0) {
                    array_push($arrayProducts, $product);

                }
            }
        }
        $categoryArr = $category->toArray();
        $categoryArr['products'] = $arrayProducts;

        return $this->showArray($categoryArr);


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
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
