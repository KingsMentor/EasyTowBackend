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
Route::get('/contact', "PagesController@contact");
Route::get('/terms', "PagesController@terms");
Route::get('/privacy', "PagesController@privacy");
Route::get('/api/doc', "PagesController@api_doc");
Route::get('/select/session/{id}', "PagesController@select_session");

Auth::routes();

Route::group(['middleware' => 'payment_detail'],function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/truck', 'HomeController@truck')->name('truck');
    Route::get('/driver', 'HomeController@driver')->name('driver');

    Route::get('/add/driver', 'HomeController@add_driver')->name('add_driver');
    Route::get('/companies', 'HomeController@companies')->name('companies');
    Route::get('/add/company', 'HomeController@add_company')->name('add_company');
    Route::post('/add/company', 'HomeController@p_add_company')->name('p_add_company');
    Route::get('/company/delete/{id}', 'HomeController@company_delete')->name('company_delete');
    Route::post('/add/driver', 'HomeController@p_add_driver')->name('p_add_driver');
    Route::get('/add/truck', 'HomeController@add_truck')->name('add_truck');
    Route::get('/truck/{id}', 'HomeController@view_truck')->name('add_truck');
    Route::get('/driver/{id}', 'HomeController@view_driver')->name('view_driver');
    Route::post('/add/driver/truck', 'HomeController@pt_add_driver')->name('add_driver');
    Route::get('/account/settings', 'HomeController@account_settings')->name('account_settings');
    Route::post('/update/account', 'HomeController@update_account')->name('update_account');


    Route::post('/add/truck', 'HomeController@p_add_truck')->name('p_add_truck');
    Route::get('/logout', 'HomeController@logout')->name('logout');

});
Route::get('/registration', 'HomeController@registration')->name('home');
Route::post('/registration', 'HomeController@p_registration')->name('home');
Route::post('/home', 'HomeController@p_registration')->name('home');
Route::get('/driver', 'PagesController@driver_')->name('driver');
Route::get('/partner', 'PagesController@partner')->name('partner');
