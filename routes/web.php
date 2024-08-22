<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [ProductController::class, 'dashboard']);
Route::post('/add-product', [ProductController::class, 'addProduct']);
Route::post('/fetch-product-data', [ProductController::class, 'fetchProductData']);
Route::post('/update-product', [ProductController::class, 'updateProduct']);
Route::post('/delete-product', [ProductController::class, 'deleteProduct']);