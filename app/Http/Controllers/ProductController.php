<?php

namespace App\Http\Controllers;

use App\Exceptions\ApplicationException;
use App\Http\Resources\ProductResource;
use App\Jobs\EmailNotifications;
use App\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 * @throws ApplicationException
	 */
    public function store(Request $request)
    {
		DB::beginTransaction();

		try {
			$product = Product::create($request->all());
			if ($product->id) {
				$product->categories()->sync([$request->category]);
			}
		} catch (Exception $e) {
			DB::rollback();
			throw new ApplicationException("Can't create product");
		}

		DB::commit();

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
		dispatch(new EmailNotifications($product, true));
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
		dispatch(new EmailNotifications($product, false));
		$product->amount = $newAmount;
		$product->save();
		return response(new ProductResource($product));
	}
}
