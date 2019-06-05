<?php

namespace App\Http\Controllers;

use App\Exceptions\ApplicationException;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\EmailNotifications;
use App\Product;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ProductRequest $request
	 * @return Response
	 * @throws ApplicationException
	 */
    public function store(ProductRequest $request)
    {
		DB::beginTransaction();
		try {
			$product = Product::create($request->all());
			if ($product->id) {
				$product->categories()->sync($request->category);
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
	 * @param ProductRequest $request
	 * @param  \App\Product $product
	 * @return Response
	 * @throws ApplicationException
	 */
    public function update(ProductRequest $request, Product $product)
    {
		DB::beginTransaction();
		$product->name = $request->name;
		$product->amount = $request->amount;
		if($product->save()){
			$product->categories()->sync($request->category);
		} else {
			DB::rollback();
			throw new ApplicationException("Can't update product");
		}
		DB::commit();
		return response(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $id
     * @return Response
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
	 * @return Response
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
	 * @return Response
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
