<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class CategoryController extends ApiController
{
     /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->showAll(Category::all()->sortBy('relevance')->values());
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
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        Category::create([
            'name' => $request->name,
            'parent' => $request->parent,
            'image' => 'default.jpg',
        ]);

        return $this->successMessageResponse('Category created successfully', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return void
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(Request $request, Category $category)
    {

        $category->update([
            'name' => $request->name,
            'parent' => $request->parent
        ]);

        return $this->successMessageResponse('ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->successMessageResponse('Producto eliminado correctamente');
        } catch (\Exception $e) {
            return $this->errorResponse('El producto ya a sido elminado o no se encuentra', '404');

        }
    }

    /**
     * GET CATEGORIES BY PARENT CATEGORY
     * @param $parent
     * @return JsonResponse
     */
    public function getCategoriesByParent($parent)
    {
        return $this->showAll(Category::all()->where('parent', '=', $parent)->sortBy('relevance')->values());
    }
}
