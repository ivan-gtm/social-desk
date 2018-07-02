<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Log;
use App\Http\Controllers\ScheduledTaskController;

class postScheduledTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auto_post';

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
        $AutoPost = new ScheduledTaskController;
        
        $AutoPost->sendScheduledPosts();

        Log::error("***********************************\n");
        Log::error("***********************************EERRROOR\n");
        Log::error("***********************************\n");
    }
}
