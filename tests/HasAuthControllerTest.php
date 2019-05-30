<?php

namespace Tests;

use App\User;

class HasAuthControllerTest extends TestCase
{
	protected $authorizedHeader;

	public function setUp(): void
	{
		parent::setUp();
		$this->artisan('passport:install');
		$user = factory(User::class)->create();
		$token = $user->createToken('TestToken')->accessToken;
		$header = [];
		$header['Accept'] = 'application/json';
		$header['Authorization'] = 'Bearer '.$token;
		$this->authorizedHeader = $header;
	}
}