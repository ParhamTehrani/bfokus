<?php

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

Route::get('/', [\App\Http\Controllers\ProductController::class,'index']);
Route::get('/search/{search}', [\App\Http\Controllers\ProductController::class,'search']);
Route::get('/result/{search}', [\App\Http\Controllers\ProductController::class,'search2']);
Route::get('/product/{asin}', [\App\Http\Controllers\ProductController::class,'one']);
Route::get('/result/{search}/page', [\App\Http\Controllers\ProductController::class,'search_page']);
Route::get('/terms', [\App\Http\Controllers\ProductController::class,'terms']);
Route::get('/accept-term', [\App\Http\Controllers\ProductController::class,'acceptTerms']);
Route::get('/policy', [\App\Http\Controllers\ProductController::class,'policy']);
