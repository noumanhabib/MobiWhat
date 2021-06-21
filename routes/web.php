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
Route::post("/search", [App\Http\Controllers\HomeController::class, 'querySearch'])->name('querySearch');
Route::post("/advn-search", [App\Http\Controllers\HomeController::class, 'advnSearch'])->name('advnSearch');
Route::get("/favourites", [App\Http\Controllers\HomeController::class, 'favourites'])->name('favourites');

Route::get("/quick-search", [App\Http\Controllers\HomeController::class, 'quickSearch'])->name('quickSearch');
Route::get("/brand/{name}", [App\Http\Controllers\BrandController::class, 'show']);

Route::post("/mobile/{id}/review", [App\Http\Controllers\MobileController::class, 'review'])->name('mobileReview');
Route::get("/mobile/{id}", [App\Http\Controllers\HomeController::class, 'mobile'])->name('mobile-product');

Auth::routes();

Route::middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'home'])->name("admin_home");
    Route::get('/admin/mobiles/add', [App\Http\Controllers\AdminController::class, 'add'])->name("mobile_add");
    Route::get('/admin/mobiles/{id}/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name("mobile_edit");
    Route::put('/admin/mobiles/{id}/update', [App\Http\Controllers\AdminController::class, 'update'])->name("mobile_update");
    Route::post('/admin/mobiles/insert', [App\Http\Controllers\AdminController::class, 'save'])->name("mobile_save");
    Route::delete('/admin/mobiles/delete', [App\Http\Controllers\AdminController::class, 'delete'])->name("mobile_delete");
    Route::delete('/admin/mobiles/{id}/delete', [App\Http\Controllers\AdminController::class, 'destroy'])->name("mobile_destroy");
});