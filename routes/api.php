<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PolicyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// API endpoint to get claim data by client
Route::get('/claims/by-client/{clientId}', [ClaimController::class, 'getClaimByClient']);

// API endpoint to get vehicles for a client
Route::get('/clients/{clientId}/vehicles', [ClientController::class, 'getVehicles']);
