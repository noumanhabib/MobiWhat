<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::redirect('/home', '/', 301);

Route::get("/brands", [App\Http\Controllers\HomeController::class, 'brands'])->name('brands');
Route::get("/top-mobiles", [App\Http\Controllers\HomeController::class, 'top'])->name('top-mobiles');
Route::get("/comparison", [App\Http\Controllers\HomeController::class, 'comparison'])->name('comparison');
Route::get("/search", [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get("/favourites", [App\Http\Controllers\HomeController::class, 'favourites'])->name('favourites');

Route::get("/mobile/{id}", [App\Http\Controllers\HomeController::class, 'mobile'])->name('mobile-product');

Auth::routes();