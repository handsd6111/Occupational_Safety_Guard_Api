<?php

use App\Http\Controllers\NotifyingAgencyController;
use App\Http\Middleware\CustomPreValidate;
use App\Models\JurisdictionRegion;
use App\Models\NotifyingAgency;
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

Route::middleware([CustomPreValidate::class])->group(function () {
    Route::prefix('notifying_agencies')->group(function () {
        Route::post('/{id?}', [NotifyingAgencyController::class, 'getNotifyingAgencies']);
        Route::post('{na_id}/jurisdiction_regions', [NotifyingAgencyController::class, 'getJurisdictionRegions']);
    });
});
