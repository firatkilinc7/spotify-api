<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SpotifyServer;

class ApiCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:api-cron-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Api Cron Job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $check = new SpotifyServer();
        $check->checkNewData();
    }
}
