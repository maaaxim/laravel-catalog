<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 5/26/19
 * Time: 11:39 PM
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	public function toArray($request)
	{
		$data = [
			"id" => $this->id,
			"name" => $this->name,
			"amount" => $this->amount
		];
		return $data;
	}
}