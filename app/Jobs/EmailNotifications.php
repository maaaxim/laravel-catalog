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
    protected $newAmount;

	/**
	 * Create a new job instance.
	 *
	 * @param Product $product
	 * @param int $newAmount
	 */
    public function __construct(Product $product, int $newAmount)
    {
        $this->product = $product;
        $this->newAmount = $newAmount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		if($this->newAmount > $this->product->amount){
			$email = new ProductReturned($this->product);
		} else {
			$email = new ProductSold($this->product);
		}
		$recipient['email'] = 'maxim@test.ru'; // @TODO hardcode
		Mail::to($recipient['email'])->send($email);
    }
}
