<?php

namespace App\Handlers\Console;

use App\User;
use Illuminate\Validation\Factory;

class CreateUserHandler
{
	/**
	 * @var Factory
	 */
	private $factory;

	/**
	 * @var
	 */
	private $email;

	/**
	 * @var
	 */
	private $password;

	/**
	 * CreateUserHandler constructor.
	 * @param Factory $factory
	 */
	public function __construct(Factory $factory)
	{
		$this->factory = $factory;
	}

	public function handle(): void
	{
		$user = new User();
		$user->name = $this->email;
		$user->email = $this->email;
		$user->password = bcrypt($this->password);
		$user->save();
	}

	/**
	 * @param mixed $password
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function setPassword(string $password): void
	{
		$this->factory->make(compact('password'), [
			'password' => 'required|min:6'
		])->validate();
		$this->password = $password;
	}

	/**
	 * @param mixed $email
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function setEmail($email): void
	{
		$this->factory->make(compact('email'), [
			'email' => 'required|email|unique:users,email',
		])->validate();
		$this->email = $email;
	}
}