<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MobileController;
use Illuminate\Http\Request;
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


Route::middleware('api.auth')->get('/mobiles', [MobileController::class, 'mobiles']);
Route::middleware('api.auth')->get('/mobile-list', [MobileController::class, 'mobileList']);
Route::middleware('api.auth')->get('/brands', [BrandController::class, 'brands']);
Route::middleware('api.auth')->get('/top_mobiles', [MobileController::class, 'topMobiles']);
Route::middleware('api.auth')->get('/search_hints', [HomeController::class, 'searchHints']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});