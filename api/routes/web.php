<?php

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
    return view('welcome');
})->name('home');

Route::get('customer/form', 'CustomerController@show_form')->name('customer_form_create');
Route::get('customer/form/{id}/edit', 'CustomerController@show_form')->name('customer_form_edit');
Route::get('customer/list', 'CustomerController@show_table')->name('customer_list');

Route::get('product/form', 'ProductController@show_product')->name('product_form_create');
Route::get('product/form/{id}/edit', 'ProductController@show_product')->name('product_form_edit');
Route::get('product/list', 'ProductController@show_table')->name('product_list');

Route::get('auth', 'UserController@auth')->name('login_form');
