<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$categories = DB::table('categories')
			->paginate(10); // @TODO magic-number
		return response(CategoryResource::collection($categories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$category = Category::create($request->all());
		return response(new CategoryResource($category));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
		$category->name = $request->name;
		$category->save();
		return response(new CategoryResource($category));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
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
	 * @return \Illuminate\Http\Response
	 */
    public function products(Category $category)
	{
		$products = $category->products;
		return response(ProductResource::collection($products));
	}
}
