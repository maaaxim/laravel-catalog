<?php

namespace App\Console;

use Illuminate\Console\Command as BaseCommand;

class Command extends BaseCommand
{
	/**
	 * @param array $errors
	 */
	public function displayErrors(array $errors): void
	{
		foreach ($errors as $error) {
			foreach ($error as $each) {
				$this->error($each);
			}
		}
	}
}