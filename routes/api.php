<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CashbackController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [AccountController::class, 'store']);
    Route::post('/cashback', [CashbackController::class, 'index']);
    Route::post('/cashback/excel', [CashbackController::class, 'excel']);
    Route::post('/cashback/pdf', [CashbackController::class, 'pdf']);
});

Route::get('/banner', [ProductController::class, 'banner']);
Route::get('/product', [ProductController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/check/login', [AuthController::class, 'checkLogin']);
Route::post('/check/otp', [AuthController::class, 'checkOtp']);
Route::post('/send/otp', [AuthController::class, 'sendOtp']);
Route::get('/province', [AddressController::class, 'province']);
Route::get('/city/{id}', [AddressController::class, 'city']);
Route::get('/subdistrict/{id}', [AddressController::class, 'subdistrict']);
Route::get('/postalcode/{id}', [AddressController::class, 'postalcode']);
Route::post('/address', [AddressController::class, 'store']);
