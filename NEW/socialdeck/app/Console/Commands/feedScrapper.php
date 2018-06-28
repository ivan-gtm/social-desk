<?php

namespace App\Console\Commands;

use Log;
use Illuminate\Console\Command;

class feedScrapper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:feed_scrapper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Log::error("***********************************\n");
        Log::error("***********************************EERRROOR\n");
        Log::error("***********************************\n");
    }
}
