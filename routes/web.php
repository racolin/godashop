<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ProductAcction;

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

Route::get('/', function () {
    return redirect()->route('home');
});

Route::group(['prefix' => '/policy'], function () {
    Route::get('/delivery', 'App\Http\Controllers\PolicyController@delivery')->name('policy.delivery');
    Route::get('/return', 'App\Http\Controllers\PolicyController@return')->name('policy.return');
    Route::get('/payment', 'App\Http\Controllers\PolicyController@payment')->name('policy.payment');
});

Route::group(['prefix' => '/account'], function() {
    Route::get('/addressDefault', 'App\Http\Controllers\AccountController@addressDefault')->name('account.addressDefault');
    Route::get('/info', 'App\Http\Controllers\AccountController@info')->name('account.info');
    Route::get('/listOrder', 'App\Http\Controllers\AccountController@listOrder')->name('account.listOrder');
    Route::get('/orderDetails', 'App\Http\Controllers\AccountController@orderDetails')->name('account.orderDetails');
    Route::post('/signup', 'App\Http\Controllers\AccountController@signup')->name('account.signup');
    Route::get('/check', 'App\Http\Controllers\AccountController@check')->name('account.check');
    Route::post('/updateAddress', 'App\Http\Controllers\AccountController@updateAddress')->name('account.updateAddress');
    Route::get('/logout', 'App\Http\Controllers\AccountController@logout')->name('account.logout');
    Route::post('/login', 'App\Http\Controllers\AccountController@login')->name('account.login');
});

Route::group(['prefix' => '/order'], function() {
    Route::get('/', 'App\Http\Controllers\OrderController@order')->name('order.order');
    Route::post('/payment', 'App\Http\Controllers\OrderController@payment')->name('order.payment');
    Route::get('/districts', 'App\Http\Controllers\OrderController@getDistricts')->name('order.districts');
    Route::get('/wards', 'App\Http\Controllers\OrderController@getWards')->name('order.wards');
});

Route::group(['prefix' => '/product'], function() {
    Route::get('/ajax/addCart', 'App\Http\Controllers\ProductController@addCart')->name('product.addCart');
    Route::get('/ajax/deleteCart', 'App\Http\Controllers\ProductController@deleteCart')->name('product.deleteCart');
    Route::get('/nextComment', 'App\Http\Controllers\ProductController@nextComment')->name('product.nextComment');
    Route::get('/details', 'App\Http\Controllers\ProductController@details')->name('product.details');
    Route::get('/{category}', 'App\Http\Controllers\ProductController@products')->name('product.products');
    Route::get('{category_id}/range', 'App\Http\Controllers\ProductController@products')->name('product.range');
    Route::get('{category_id}/sort', 'App\Http\Controllers\ProductController@products')->name('product.sort');
    Route::get('{category_id}/{v1}/{v2}', 'App\Http\Controllers\ProductController@products')->middleware(ProductAcction::class)->name('product.mix');
    Route::post('/comment', 'App\Http\Controllers\ProductController@comment')->name('product.comment');
});

Route::get('/home', 'App\Http\Controllers\HomeController@home')->name('home');

Route::get('/contact', 'App\Http\Controllers\ContactController@contact')->name('contact');
