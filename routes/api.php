<?php

use Illuminate\Support\Facades\Route;
use The3labsTeam\NovaBusyResourceField\App\Http\Controllers\BusyController;

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

Route::post('/is-busy', [BusyController::class, 'isBusy']);
Route::post('/store-busy', [BusyController::class, 'storeBusy']);
