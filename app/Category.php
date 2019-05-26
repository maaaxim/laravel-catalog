<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
    public function products()
	{
		return $this->belongsToMany(
			Product::class,
			'category_product',
			'category_id',
			'product_id'
		);
	}
}
