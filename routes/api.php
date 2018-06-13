<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


$api = app(Dingo\Api\Routing\Router::class);


$api->version('v1', ['namespace' => '\App\Http\Controllers'], function ($api) {

    $api->patch('/auth/refresh', [
        'uses' => 'APIAuthenticateController@patchRefresh',
    ]);

    $api->post('auth/login', 'APIAuthenticateController@postLogin');
    $api->post('auth/sign-up', 'APIAuthenticateController@sign_up');
    $api->post('auth/logout', 'APIAuthenticateController@logout');
    $api->post('driver/login', 'APIAuthenticateController@driverLogin');
    $api->post('driver/sign-up', 'APIAuthenticateController@driver_sign_up');
    $api->post('update/gps', 'APIAuthenticateController@updateGPS');
    $api->post('find/tow', 'APIAuthenticateController@find_tow');

    $api->post('transactions', 'APIAuthenticateController@transaction');

    $api->post('auth/send-password-reset-link', 'APIAuthenticateController@send_password_reset_link');
    $api->post('/check/phone', 'APIOthersController@checkPhoneNo');
    $api->post('/check/email', 'APIOthersController@checkEmail');
    $api->post('/check/socialId', 'APIOthersController@check_social_id');

    $api->group(['middleware' => 'api.aut'], function ($api) {
        $api->post('/auth/change-password', 'APIAuthenticateController@change_password');
        $api->post('/auth/update/profile', 'APIAuthenticateController@update_profile');
        $api->post('/auth/add/address', 'APIAuthenticateController@add_address');
        $api->post('/auth/remove/address', 'APIAuthenticateController@remove_address');

        $api->delete('/auth/invalidate', [
            'uses' => 'APIAuthenticateController@deleteInvalidate',
        ]);
        $api->get('/auth/user', [
            'uses' => 'APIAuthenticateController@getUser',
        ]);

        $api->post('/delete/account', 'APIAuthenticateController@deleteUser');

        $api->post('/update/gcm', 'APIOthersController@updateGCMIDS');



    });

    $api->post('/jwt/refresh', '\Paulvl\JWTGuard\Http\Controllers\Auth\LoginController@refresh')->name('jwt.refresh');
});