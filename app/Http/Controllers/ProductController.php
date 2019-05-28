<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Jobs\EmailNotifications;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$product = Product::create($request->all());
		return response(new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
		$product->name = $request->name;
		$product->amount = $request->amount;
		$product->save();
		return response(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$product = Product::find($id);
		if(!$product){
			return response("Product not found");
		}
		$product->delete();
		return response(new ProductResource($product));
    }

	/**
	 * @param Product $product
	 * @return \Illuminate\Http\Response
	 */
    public function sellItem(Product $product)
	{
		$newAmount = $product->amount - 1;
		dispatch(new EmailNotifications($product, $newAmount));
		if($product->amount > 0){
			$product->amount = $newAmount;
			$product->save();
		}
		return response(new ProductResource($product));
	}

	/**
	 * @param Product $product
	 * @return \Illuminate\Http\Response
	 */
	public function returnItem(Product $product)
	{
		$newAmount = $product->amount + 1;
		dispatch(new EmailNotifications($product, $newAmount));
		$product->save();
		return response(new ProductResource($product));
	}
}
