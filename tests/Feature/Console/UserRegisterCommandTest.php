<?php

namespace Tests\Feature\Console;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserRegisterCommandTest extends TestCase
{
	use DatabaseMigrations;

	public function test_user_create()
	{
		$this->artisan('user:register vasily vasily@mail.ru 112233')
			->assertExitCode(0);
		$this->assertDatabaseHas('users', [
			'name' => 'vasily',
			'email' => 'vasily@mail.ru',
		]);
	}
}
