<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderdetailController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\CartController;



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

Auth::routes();

Route::get('/', [DisplayController::class, 'index'])->name('home');
Route::get('/search', [DisplayController::class, 'search'])->name('display.search');


Route::group(['middleware' =>'auth'], function(){

    // リソースコントローラー群
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('orderdetails', OrderdetailController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('favorites', FavoriteController::class);
    Route::resource('reoports', ReportController::class);
    Route::resource('carts', CartController::class);

    //UserController追加ルーティング
    Route::get('users/{user}/delete/conf', [UserController::class, 'deleteconf'])->name('users.deleteconf');

    //OrderController追加ルーティング
    Route::get('orders/index/mypage', [OrderController::class, 'myindex'])->name('orders.myindex');
    //OrderdetailController追加ルーティング 
    //単品注文の処理
    Route::get('orderdetails/create/guest/{product}', [OrderdetailController::class, 'createguest'])->name('orderdetails.createguest');
    Route::post('orderdetails/create/conf/{product}', [OrderdetailController::class, 'createconf'])->name('orderdetails.createconf');
    Route::post('orderdetails/create/complete/{product}', [OrderdetailController::class, 'createcomplete'])->name('orderdetails.createcomplete');
    //カートから一括注文の処理
    Route::post('orderdetails/create/allconf', [OrderdetailController::class, 'callconf'])->name('orderdetails.callconf');
    Route::post('orderdetails/create/allcomplete', [OrderdetailController::class, 'callcomplete'])->name('orderdetails.callcomplete');

    //ProductController追加ルーティング
    Route::get('products/index/mypage', [ProductController::class, 'myindex'])->name('products.myindex');
    Route::post('products/create/conf', [ProductController::class, 'createconf'])->name('products.createconf');
    Route::get('products/{product}/delete/conf', [ProductController::class, 'deleteconf'])->name('products.deleteconf');
    Route::post('products/{product}/edit/conf', [ProductController::class, 'editconf'])->name('products.editconf');
    Route::get('products/{product}/report/conf', [ProductController::class, 'reportconf'])->name('products.reportconf');
    Route::post('products/report/comp', [ProductController::class, 'reportcomp'])->name('products.reportcomp');

    //CartController追加ルーティング
    Route::get('carts/create/guest/{product}', [CartController::class, 'createguest'])->name('carts.createguest');

    //CommentController追加ルーティング
    Route::get('comment/create/guest/{product}', [CommentController::class, 'createguest'])->name('comments.createguest');


});
