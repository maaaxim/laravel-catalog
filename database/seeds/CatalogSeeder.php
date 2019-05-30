<?php

use App\Category;
use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($r = 0; $r < 10; $r++) {
			$category = factory(Category::class)->create();
			for($i = 0; $i < 10; $i++){
				DB::table('category_product')->insert(
					array(
						'product_id' => factory(Product::class)->create()->id,
						'category_id' => $category->id,
					)
				);
			}
		}
    }
}
