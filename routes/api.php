<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\PriceListElementController;
use App\Http\Controllers\ProductController;
use App\Models\User;
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


Route::group(['middleware'=>['auth:sanctum']], function() {
    Route::prefix('auth')->group(function() {
        Route::get('user', [AuthController::class, 'user']);
        Route::get('token', [AuthController::class, 'token']);

        // unauthorized are allowed to access this place
        Route::post('login', [AuthController::class, 'login'])
            ->withoutMiddleware('auth:sanctum');
    });

    Route::apiResources([
        'products' => ProductController::class,
        'pricelists' => PriceListController::class,
        'pricelistelements' => PriceListElementController::class
    ]);
});

// for testing purposes only
Route::get('test', [\App\Http\Controllers\TestConroller::class, 'test']);
