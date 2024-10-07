<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\GroupAreaController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PicController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\ReviewsController;
use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\TopologyController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VirtualMachineController;
use App\Http\Controllers\UserDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes
| be assigned to the "api" middleware group. Make something great!for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
|
 */
Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('/applications', ApplicationController::class)
        ->except([
            'index',
            'show', 'update']);
    Route::post('/applications/{id}', [ApplicationController::class, 'update']); //tidak bisa menggunakan put untuk mengirim multiform, jadi dipisahkan manual agar bisa mengirim request pada postman
    Route::post('/applications/import', [ApplicationController::class, 'import']);
    Route::apiResource('/reviews', ReviewsController::class);
    Route::apiResource('/virtual_machines', VirtualMachineController::class);
    Route::apiResource('/technologies', TechnologyController::class);
    Route::apiResource('/topologies', TopologyController::class);
    Route::apiResource('/pics', PicController::class);
    Route::apiResource('/group_areas', GroupAreaController::class)->except(['update']);
    route::post('/group_areas/{id}', [GroupAreaController::class, 'update']); //tidak bisa menggunakan put untuk mengirim multiform, jadi dipisahkan manual agar bisa mengirim request pada postman
    Route::apiResource('/companies', CompanyController::class)->except(['update']);
    route::post('/companies/{id}', [CompanyController::class, 'update']); //tidak bisa menggunakan put untuk mengirim multiform, jadi dipisahkan manual agar bisa mengirim request pada postman
    Route::apiResource('/users', UserController::class)->except(['update']);
    route::post('/users/{id}', [UserController::class, 'update']); //tidak bisa menggunakan put untuk mengirim multiform, jadi dipisahkan manual agar bisa mengirim request pada postman
    Route::get('/users-client', [UserDetailController::class, 'indexClient']); //get user role client
    Route::get('/users-teknisi', [UserDetailController::class, 'indexTeknisi']); //get user role teknisi

    //must admin
    Route::middleware('admin')->group(function () {
        Route::post('/disable-2fa/{id}', [GoogleAuthController::class, 'disable2FA']);
    });

    Route::get('/applications', [ApplicationController::class, 'index']);
    Route::get('/applications/{applications}', [ApplicationController::class, 'show']);
    Route::get('/reviews', [ReviewsController::class, 'index']);
    Route::post('/logout', LogoutController::class)->name('logout');
    Route::post('refresh', [LogoutController::class, 'refresh']);

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/register-2fa', [GoogleAuthController::class, 'show2faRegistration'])->name('2fa.registration');
    Route::post('/complete-register-2fa', [GoogleAuthController::class, 'completeRegistration'])->name('2fa.complete');
    Route::post('/enable-2fa', [GoogleAuthController::class, 'enable2FA']);
    Route::post('/validate-user', [UserController::class, 'validateUser']);
});

//for guest, no need to login. need to logout first if already login (no authenticate/credential).
Route::middleware(['guest'])->group(function () {
    Route::post('forgot-password', [ResetPasswordController::class, 'requestReset']);
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
    //Route::post('/password-reset', [LoginController::class, 'passwordReset']);
    Route::get('/admin-contact', [UserController::class, 'getAdminContact']);
});
