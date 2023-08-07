<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\NotifyingAgencyController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CustomPreValidate;
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

Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class, 'create']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh_token', [AuthController::class, 'refreshToken'])->middleware('auth:user');
});

Route::middleware([CustomPreValidate::class])->group(function () {
    Route::prefix('notifying_agencies')->group(function () {
        Route::get('/{id?}', [NotifyingAgencyController::class, 'getNotifyingAgencies']);
        Route::get('{na_id}/jurisdiction_regions', [NotifyingAgencyController::class, 'getJurisdictionRegions']);
    });
    Route::prefix('counties')->group(function () {
        Route::get('', [CountyController::class, 'getCounty']);
        Route::get('/{county_code}/towns', [CountyController::class, 'getTown']);
    });
    Route::prefix('industries')->group(function () {
        Route::get('', [IndustryController::class, 'getIndustry']);
        Route::get('/{code}', [IndustryController::class, 'getIndustry'])->withoutMiddleware(CustomPreValidate::class);
    });
});
