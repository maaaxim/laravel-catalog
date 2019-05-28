<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class UserRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register
                            {username : User name}
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
     * @return mixed
     */
    public function handle()
    {
		$this->info("Creating new user...");

		$user = new User();
		$user->name = $this->argument('username');
		$user->email = $this->argument('email');
		$user->password = bcrypt($this->argument('password'));
		$user->save();

		$this->info("User created successfully!");
    }
}
