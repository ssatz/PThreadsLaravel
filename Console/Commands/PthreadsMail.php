<?php

namespace Artisan\Console\Commands;

use Illuminate\Console\Command;
use Threads\Query;
use Threads\Connect;

class PthreadsMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailer:pthreads';
    protected $database;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail Sent using Pthreads';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->database = include('config/database.php');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);
        $pool = new \Pool(4, Connect::class, [$this->database['mysql']]);
        $pool->submit(new Query('Select name, email from users  Limit 1,50000'));
        $pool->submit(new Query('Select name, email from users  Limit 50000,100000'));
        $pool->shutdown();
        printf("Done for %.2f seconds".PHP_EOL,microtime(true)-$start);
    }
}
