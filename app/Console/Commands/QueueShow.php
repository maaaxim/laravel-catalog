<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class QueueShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:show
								{start : start from}
								{stop : limit (-1 for all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows queue';

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
		$start = $this->argument('start');
		$stop = $this->argument('stop');
		$redis = Redis::connection();
		$queueItems = $redis->lrange('laravel_catalog_database_queues:default', $start, $stop);
		dd($queueItems);
    }
}
