<?php

namespace Tests\Feature\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\HasAuthControllerTest;

class CategoryControllerTest extends HasAuthControllerTest
{
	use DatabaseMigrations;

	public function test_can_get_categories()
	{
		factory(Category::class, 10)->create();
		$response = $this->json('GET', '/api/categories', []);
		$response->assertStatus(200);
		$response->assertJsonStructure([
			["id", "name"]
		]);
	}

	public function test_can_get_empty_categories()
	{
		$response = $this->json('GET', '/api/categories', []);
		$response->assertStatus(200);
		$response->assertJsonStructure([]);
	}

	public function test_authorized_store_category()
	{
		$response = $this->json('POST', '/api/categories', [
			'name' => 'Test category',
		]);
		$response->assertStatus(401);
	}

	public function test_can_store_category()
	{
		$response = $this->json('POST', '/api/categories', [
			'name' => 'Test category',
		], $this->authorizedHeader);
		$response->assertStatus(200);
		$response->assertJsonFragment([
			'name' => 'Test category',
		]);
		$this->assertDatabaseHas('categories', [
			'name' => 'Test category',
		]);
	}

	public function test_authorized_put_category()
	{
		$category = factory(Category::class)->create();
		$response = $this->json('PUT', '/api/categories/' . $category->id, [
			'name' => 'Test category',
		]);
		$response->assertStatus(401);
	}

	public function test_can_put_category()
	{
		$category = factory(Category::class)->create();
		$response = $this->json('PUT', '/api/categories/' . $category->id, [
			'name' => 'Test category',
		], $this->authorizedHeader);
		$response->assertStatus(200);
		$response->assertJsonFragment([
			'name' => 'Test category',
		]);
		$this->assertDatabaseHas('categories', [
			'name' => 'Test category',
		]);
	}

	public function test_can_delete_category()
	{
		$category = factory(Category::class)->create();
		$response = $this->json(
			'DELETE',
			'/api/categories/' . $category->id,
			[],
			$this->authorizedHeader
		);
		$response->assertStatus(200);
		$this->assertDatabaseMissing('categories', [
			'id' => $category->id,
		]);
	}

	public function test_authorized_delete_category()
	{
		$category = factory(Category::class)->create();
		$response = $this->json('DELETE', '/api/categories/' . $category->id, []);
		$response->assertStatus(401);
	}

	public function test_can_get_product_list()
	{
		$category = factory(Category::class)->create();
		for($i = 0; $i < 10; $i++){
			DB::table('category_product')->insert(
				[
					'product_id' => factory(Product::class)->create()->id,
					'category_id' => $category->id,
				]
			);
		}
		$response = $this->json(
			'GET',
			'/api/categories/' . $category->id . '/products',
			[]
		);
		$response->assertStatus(200);
		$response->assertJsonStructure([
			["id", "name"]
		]);
	}

	public function test_error_get_product_list_wrong_category()
	{
		$response = $this->json(
			'GET',
			'/api/categories/100500/products',
			[]
		);
		$response->assertStatus(404);
	}

	public function test_error_get_product_list_empty_category()
	{
		$category = factory(Category::class)->create();
		$response = $this->json(
			'GET',
			'/api/categories/' . $category->id . '/products',
			[]
		);
		$response->assertStatus(200);
		$response->assertJsonStructure([]);
	}

	public function test_store_empty_name()
	{
		$response = $this->json('POST', '/api/categories', [
			'name' => '',
		], $this->authorizedHeader);
		$response->assertStatus(422);
		$response->assertJsonFragment([
			'message' => 'The given data was invalid.',
		]);
	}

	public function test_store_wrong_format_name()
	{
		$response = $this->json('POST', '/api/categories', [
			'name' => rand(0, 100000),
		], $this->authorizedHeader);
		$response->assertStatus(422);
		$response->assertJsonFragment([
			'message' => 'The given data was invalid.',
		]);
	}

	public function test_put_empty_name()
	{
		$category = factory(Category::class)->create();
		$response = $this->json('PUT', '/api/categories/' . $category->id, [
			'name' => '',
		], $this->authorizedHeader);
		$response->assertStatus(422);
		$response->assertJsonFragment([
			'message' => 'The given data was invalid.',
		]);
	}

	public function test_put_wrong_format_name()
	{
		$category = factory(Category::class)->create();
		$response = $this->json('PUT', '/api/categories/' . $category->id, [
			'name' => rand(0, 100000),
		], $this->authorizedHeader);
		$response->assertStatus(422);
		$response->assertJsonFragment([
			'message' => 'The given data was invalid.',
		]);
	}

	public function test_put_resource_id_not_number()
	{
		$response = $this->json('POST', '/api/categories/text', [
			'name' => 'Some info',
		], $this->authorizedHeader);
		$response->assertStatus(404);
		$response->assertJsonFragment([
			'message' => 'Route not exist.',
		]);
	}

	public function test_put_resource_id_not_found()
	{
		$response = $this->json('PUT', '/api/categories/1', [
			'name' => 'Some info',
		], $this->authorizedHeader);
		$response->assertStatus(404);
		$response->assertJsonFragment([
			'message' => 'Resource not found.',
		]);
	}
}