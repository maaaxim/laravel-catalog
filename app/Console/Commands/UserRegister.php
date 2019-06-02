<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Handlers\Console\CreateUserHandler;
use Illuminate\Validation\ValidationException;

class UserRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register
                            {email : User e-mail}
                            {password : User password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * Execute the console command.
	 *
	 * @param CreateUserHandler $handler
	 * @return mixed
	 */
    public function handle(CreateUserHandler $handler)
    {
		$this->info("Creating new user...");
		try {
			$handler->setEmail($this->argument('email'));
			$handler->setPassword($this->argument('password'));
			$handler->handle();
			$this->info("User created successfully!");
		} catch (ValidationException $exception) {
			$this->displayErrors($exception->errors());
			$this->error("User was not created!");
		}
    }
}
