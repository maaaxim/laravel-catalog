<?php

namespace App\Mail;

/**
 * Class ProductSold
 * @package App\Mail
 */
class ProductSold extends ProductOperationEmailAbstract
{
	public $view = 'email.product_sold';
}
