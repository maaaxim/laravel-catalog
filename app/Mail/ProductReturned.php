<?php

namespace App\Mail;

/**
 * Class ProductReturned
 * @package App\Mail
 */
class ProductReturned extends ProductOperationEmailAbstract
{
	public $view = 'email.product_returned';
}
