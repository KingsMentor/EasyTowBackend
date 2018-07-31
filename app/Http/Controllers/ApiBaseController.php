<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ApiBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $APP_CONSTANT;
    public $default_url;
    public $default_token;
    public $default_path;
    public $firebase;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->APP_CONSTANT = app_constants();
    }

    public function appendTimeStamp($array)
    {
        $now = Carbon::now();
        return array_merge($array, ['created_at' => $now, 'updated_at' => $now]);
    }

    public function user()
    {
        return $this->auth()->user();
    }

    public function auth()
    {
        return auth();
    }

    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    protected function onUnauthorized()
    {
        $app_const = $this->APP_CONSTANT;
        return genericResponse($app_const["INVALID_CREDENTIALS"], "401", null);

    }

    protected function onJwtGenerationError()
    {

        $app_const = $this->APP_CONSTANT;
        return genericResponse($app_const["TOKEN_CREATION_ERR"], "500", null);

    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}
