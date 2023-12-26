<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\APi\ReviewController;
use App\Http\Controllers\APi\ResultController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::put('/user/{id}',          'update')->name('user.update');
        Route::get('/user/{id}',          'show');
        Route::put('/user/password/{id}', 'password')->name('user.password');
        Route::put('/user/email/{id}',    'email')->name('user.email');
        Route::delete('/user/{id}',       'destroy');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout',            'logout');
    });
});
Route::controller(ReviewController::class)->group(function () {
    Route::get('/review',                 'index');
    Route::get('/review/{id}',            'show');
    Route::post('/review',                'store');
    Route::delete('/review/{id}',         'destroy');
});

Route::controller(ResultController::class)->group(function () {
    Route::get('/result',                 'index');
    Route::post('/result',                'store');
});
