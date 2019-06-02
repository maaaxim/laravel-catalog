<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
		$categories = DB::table('categories')
			->paginate(10);
		return response(CategoryResource::collection($categories));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CategoryRequest $request
	 * @return Response
	 */
    public function store(CategoryRequest $request)
    {
		$category = Category::create($request->all());
		return response(new CategoryResource($category));
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param CategoryRequest $request
	 * @param  \App\Category $category
	 * @return Response
	 */
    public function update(CategoryRequest $request, Category $category)
    {
		$category->name = $request->name;
		$category->save();
		return response(new CategoryResource($category));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 * @throws Exception
	 */
    public function destroy(int $id)
    {
    	$category = Category::find($id);
    	if(!$category){
			return response("Category not found");
		}
		$category->delete();
		return response(new CategoryResource($category));
    }

	/**
	 * @param Category $category
	 * @return Response
	 */
    public function products(Category $category)
	{
		$products = $category->products;
		return response(ProductResource::collection($products));
	}
}
