<?php

namespace Tests\Feature\Http\Controllers;

use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\HasAuthControllerTest;

class ProductControllerTest extends HasAuthControllerTest
{
	use DatabaseMigrations;

	public function test_authorized_store_product()
	{
		$response = $this->json('POST', '/api/products', [
			'name' => 'Test product',
		]);
		$response->assertStatus(401);
	}

	public function test_can_store_product()
	{
		$response = $this->json('POST', '/api/products', [
			'name' => 'Test product',
			'amount' => 100,
		], $this->authorizedHeader);
		$response->assertStatus(200);
		$response->assertJsonFragment([
			'name' => 'Test product',
			'amount' => 100,
		]);
		$this->assertDatabaseHas('products', [
			'name' => 'Test product',
			'amount' => 100,
		]);
	}

	public function test_authorized_put_product()
	{
		$product = factory(Product::class)->create();
		$response = $this->json('PUT', '/api/products/' . $product->id, [
			'name' => 'Test product',
		]);
		$response->assertStatus(401);
	}

	public function test_can_put_product()
	{
		$product = factory(Product::class)->create();
		$response = $this->json('PUT', '/api/products/' . $product->id, [
			'name' => 'Test product',
			'amount' => 100,
		], $this->authorizedHeader);
		$response->assertStatus(200);
		$response->assertJsonFragment([
			'name' => 'Test product',
			'amount' => 100,
		]);
		$this->assertDatabaseHas('products', [
			'name' => 'Test product',
			'amount' => 100,
		]);
	}

	public function test_can_delete_product()
	{
		$product = factory(Product::class)->create();
		$response = $this->json(
			'DELETE',
			'/api/products/' . $product->id,
			[],
			$this->authorizedHeader
		);
		$response->assertStatus(200);
		$this->assertDatabaseMissing('products', [
			'id' => $product->id,
		]);
	}

	public function test_authorized_delete_product()
	{
		$product = factory(Product::class)->create();
		$response = $this->json('DELETE', '/api/products/' . $product->id, []);
		$response->assertStatus(401);
	}

	public function test_increase_product()
	{
		$product = factory(Product::class)->create([
			'name' => 'Test product',
			'amount' => 10
		]);
		$response = $this->json('GET', '/api/products/' . $product->id . '/return', []);
		$response->assertStatus(200);
		$response->assertExactJson(['id' => $product->id, 'name' => 'Test product', 'amount' => 11]);
	}

	public function test_decrease_product()
	{
		$product = factory(Product::class)->create([
			'name' => 'Test product',
			'amount' => 10
		]);
		$response = $this->json('GET', '/api/products/' . $product->id . '/sell', []);
		$response->assertStatus(200);
		$response->assertExactJson(['id' => $product->id, 'name' => 'Test product', 'amount' => 9]);
	}

	public function test_decrease_less_then_null_product()
	{
		$product = factory(Product::class)->create([
			'name' => 'Test product',
			'amount' => 0
		]);
		$response = $this->json('GET', '/api/products/' . $product->id . '/sell', []);
		$response->assertStatus(200);
		$response->assertExactJson(['id' => $product->id, 'name' => 'Test product', 'amount' => 0]);
	}
}