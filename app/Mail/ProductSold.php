<?php

namespace App\Mail;

use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * @TODO DRY
 *
 * Class ProductSold
 * @package App\Mail
 */
class ProductSold extends Mailable
{
    use Queueable, SerializesModels;

    protected $product;

	/**
	 * Create a new message instance.
	 *
	 * @param Product $product
	 */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.product_sold')
			->withProduct($this->product);
    }
}
