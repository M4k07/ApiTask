<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\MailController;
// use App\Http\Middleware\CheckIfEndpointIsUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['checkApiStatus'])->get('/import-data', [DataController::class, 'store']);
Route::get('send-mail', [MailController::class, 'index']);