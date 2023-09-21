<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\apiCronService;

class CronController extends Controller
{
    public function runApiCronJob(apiCronService $cronService)
    {
        $cronService->runApiCronJob();
        return response()->json([
            "message" => "Cron job manually executed."
        ]);
    }
}
