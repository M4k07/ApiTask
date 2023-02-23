<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
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
        $client = new Client();

        $endpoints = [
            env("API_URL_USER"),
            env("API_URL_POST"),
        ];

        foreach ($endpoints as $endpoint) {
            $response = $client->get($endpoint);

            if ($response->getStatusCode() !== 200) {
                return response()->json(['error' => 'API endpoint is not responding'], 500);
            }
        }
        return $next($request);
    }
}
