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

Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // 一覧
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search'); // 検索

Route::get('/products/register', [ProductController::class, 'create'])->name('products.create'); // 登録画面
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store'); // 登録処理

Route::get('/products/{productId}', [ProductController::class, 'show'])->name('products.show'); // 詳細
Route::get('/products/{productId}/update', [ProductController::class, 'edit'])->name('products.edit'); // 編集画面
Route::post('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update'); // 更新処理

Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy'); // 削除



