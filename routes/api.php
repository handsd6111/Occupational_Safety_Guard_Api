<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\MajorOccupationalAccidentController;
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
    });

    Route::prefix('jurisdiction_regions')->group(function () {
        Route::get('', [NotifyingAgencyController::class, 'getJurisdictionRegions']);
        Route::get('{jr_id}/notifying_agencies', [NotifyingAgencyController::class, 'getNotifyingAgenciesByJrId']);
    });

    Route::prefix('counties')->group(function () {
        Route::get('', [CountyController::class, 'getCounty']);
        Route::get('/{county_code}/towns', [CountyController::class, 'getTown']);
    });
    Route::prefix('industries')->group(function () {
        Route::get('', [IndustryController::class, 'getIndustry']);
        Route::get('/{code}', [IndustryController::class, 'getIndustry'])->withoutMiddleware(CustomPreValidate::class);
    });

    Route::prefix('major_occupational_accidents')->group(function () {
        Route::get('', [MajorOccupationalAccidentController::class, 'getMajorOccupationalAccidents']);
    });

    Route::get('accident_type_statistics', [MajorOccupationalAccidentController::class, 'getAccidentTypeStatistics'])->withoutMiddleware(CustomPreValidate::class);
    Route::get('industry_statistics', [MajorOccupationalAccidentController::class, 'getIndustryStatistics'])->withoutMiddleware(CustomPreValidate::class);
});
