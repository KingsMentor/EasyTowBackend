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

Route::get('/', "PagesController@index");

Auth::routes();

Route::group(['middleware' => 'payment_detail'],function(){
    Route::get('/home', 'HomeController@index')->name('home');

});
Route::get('/registration', 'HomeController@registration')->name('home');
Route::post('/registration', 'HomeController@p_registration')->name('home');
Route::post('/home', 'HomeController@p_registration')->name('home');
