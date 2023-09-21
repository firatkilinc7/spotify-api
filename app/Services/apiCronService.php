<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;

class apiCronService
{
    public function runApiCronJob()
    {

        Artisan::call('app:api-cron-job');
    }
}
