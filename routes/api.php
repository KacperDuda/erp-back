<?php

use App\Http\Controllers\AuthController;
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
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
    });
});










if(env('APP_ENV') == "local") {
    Route::get('getAdminToken', function (Request $request) {
        $user = User::findOrFail(1);
        $token = $user->createToken('admin_token', $user->abilities);

        return ['token' => $token->plainTextToken];
    })->withoutMiddleware('csrf');

    Route::get('restart', function (Request $request) {
        User::create([
            'name' =>'Admin',
            'email' => 'admin@admin.pl',
            'password' => Hash::make('admin'),
            'is_admin' => true,
            'abilities' => ['users:modify']
        ]);
    })->withoutMiddleware('csrf');

}
