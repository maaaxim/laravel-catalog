<?php

namespace App\Jobs;

use App\Mail\ProductReturned;
use App\Mail\ProductSold;
use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EmailNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * @var
	 */
    protected $product;

	/**
	 * @var
	 */
    protected $sold;

	/**
	 * Create a new job instance.
	 *
	 * @param Product $product
	 * @param bool $sold
	 */
    public function __construct(Product $product, bool $sold)
    {
        $this->product = $product;
        $this->sold = $sold;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		if($this->sold !== true){
			$email = new ProductReturned($this->product);
			echo "returned";
		} else {
			$email = new ProductSold($this->product);
			echo "sold";
		}
		$recipient['email'] = 'maxim@test.ru'; // @TODO hardcode
		Mail::to($recipient['email'])->send($email);
    }
}
