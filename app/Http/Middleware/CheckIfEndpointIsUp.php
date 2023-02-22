<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckIfEndpointIsUp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = Http::get($request->url());
        if($response->getStatusCode() !== 200) {
            return response()->json([
                'status' => 'error',
                'message' => 'endpoint not responding'
            ],500);
        }
        return $next($request);
    }
}
