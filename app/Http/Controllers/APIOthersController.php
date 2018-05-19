<?php

namespace App\Http\Controllers;

use App\ApiLog;
use App\Category;
use App\City;
use App\Combo;
use App\Dispatcher;
use App\Gcm_id;
use App\Food;
use App\Order;
use App\OrderItem;
use App\Rate;
use App\Transformers\CategoryTransformer;
use App\Transformers\CombTransformer;
use App\Transformers\FoodTransformer;
use App\Transformers\OrderTransformer;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIOthersController extends ApiBaseController
{

    public function __construct()
    {
        parent::__construct();
    }


}
