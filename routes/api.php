<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\NotifyingAgencyController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\AuthenticateForAdmin;
use App\Http\Middleware\CustomPreValidate;
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
use App\Models\User;

Route::get('test', function () {
    // return (User::first()->roles->where('name', '使用者'));
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

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

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

Route::get('/execute-command', function () {
    // Storage::delete('access_rsa');
    // Storage::delete('access_rsa.pub');
    // $output = null;
    // $returnValue = null;
    // $command = 'openssl genpkey -algorithm RSA -out ../storage/app/access_rsa -pkeyopt rsa_keygen_bits:2048';


    // exec($command, $output, $returnValue);

    // if ($returnValue === 0) {
    //     // 命令執行成功
    //     return response()->json([
    //         'output' => $output,
    //         'message' => 'SSH key pair generated successfully.',
    //     ]);
    // } else {
    //     // 命令執行失敗
    //     return response()->json([
    //         'output' => $output,
    //         'message' => 'Failed to generate SSH key pair.',
    //     ]);
    // }
    Storage::delete('access_rsa.pub');
    $output = null;
    $returnValue = null;
    $command = 'openssl rsa -in ../storage/app/access_rsa -pubout -out ../storage/app/access_rsa.pub';


    exec($command, $output, $returnValue);

    if ($returnValue === 0) {
        // 命令執行成功
        return response()->json([
            'output' => $output,
            'message' => 'aSSH key pair generated successfully.',
        ]);
    } else {
        // 命令執行失敗
        return response()->json([
            'output' => $output,
            'message' => 'aFailed to generate SSH key pair.',
        ]);
    }
});
