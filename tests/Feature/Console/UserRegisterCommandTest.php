<?php

namespace Tests\Feature\Console;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserRegisterCommandTest extends TestCase
{
	use DatabaseMigrations;

	public function test_user_create()
	{
		$this->artisan('user:register vasily@mail.ru 112233')
			->assertExitCode(0);
		$this->assertDatabaseHas('users', [
			'name' => 'vasily@mail.ru',
			'email' => 'vasily@mail.ru',
		]);
	}

	public function test_empty_email()
	{
		$this->artisan('user:register "" 112233')
			->expectsOutput('The email field is required.')
			->expectsOutput('User was not created!')
			->assertExitCode(0);
	}

	public function test_empty_password()
	{
		$this->artisan('user:register vasily@mail.ru ""')
			->expectsOutput('The password field is required.')
			->expectsOutput('User was not created!')
			->assertExitCode(0);
	}

	public function test_weak_password()
	{
		$this->artisan('user:register vasily@mail.ru 123')
			->expectsOutput('The password must be at least 6 characters.')
			->expectsOutput('User was not created!')
			->assertExitCode(0);
	}

	public function test_incorrect_email()
	{
		$this->artisan('user:register vasilymailru 112233')
			->expectsOutput('The email must be a valid email address.')
			->expectsOutput('User was not created!')
			->assertExitCode(0);
	}

	public function test_user_already_exist()
	{
		$user = factory(User::class)->create();
		$this->artisan(
			'user:register '
			. $user->email
			. ' '
			. '112233')
			->expectsOutput('The email has already been taken.')
			->expectsOutput('User was not created!')
			->assertExitCode(0);
	}
}
