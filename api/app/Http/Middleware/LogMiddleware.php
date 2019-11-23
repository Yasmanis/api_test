<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use App\Logs;
class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // Save Laravel Logs
        $end = microtime(true);
        $start = microtime(true);
        $duration = $end - $start;
        $url = $request->fullUrl();
        $method = $request->getMethod();
        $ip = $request->getClientIp();
        $status = $response->status();

        $log = "{$ip}: [{$status}] {$method}@{$url} {$duration}ms";

        Log::info($log);

        // Save Table Logs
        $logs = new Logs;
        $logs->request = "IP: {$ip} Method: {$method} URL: {$url}";
        $logs->response = "STATUS: [{$status}] DURATION: {$duration}ms";
        $logs->save();
    }

}
