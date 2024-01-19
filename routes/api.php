<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::post('/api/busy-is-busy', [\The3labsTeam\NovaBusyResourceField\App\Http\Controllers\BusyController::class, 'isBusy']);
Route::post('/api/busy-store-busy', [\The3labsTeam\NovaBusyResourceField\App\Http\Controllers\BusyController::class, 'storeBusy']);
Route::post('/api/busy-update-busy-date', [\The3labsTeam\NovaBusyResourceField\App\Http\Controllers\BusyController::class, 'updateBusyDate']);
