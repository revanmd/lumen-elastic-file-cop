<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use DateTime;
use DateTimeZone;

use App\Utils\ElasticService;

class LogMiddleware
{
    public function __construct(
        ElasticService $elasticService
    ){
        $this->elasticService = $elasticService;
    }

    public function handle($request, Closure $next)
    {
        
        // Captured time at incoming request
        $micro_at =  floor(microtime(true) * 1000);
        $date = new DateTime("now", new DateTimeZone('UTC') );
        $request_at = $date->format('Y/m/d H:i:s');
        
        // Do something
        $response =  $next($request);

        // Captured time at response 
        $micro_end =  floor(microtime(true) * 1000);
        $date = new DateTime("now", new DateTimeZone('UTC') );
        $response_at = $date->format('Y/m/d H:i:s');
        

        $dif = $micro_end - $micro_at;

        $this->elasticService->SendLog($request, $response, [$request_at, $response_at], $dif);
        return $response;
    }
}
