<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Transformers\DriverTransformer;
use App\Trip;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Sodium\crypto_box_publickey_from_secretkey;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;

class DriverApiController extends Controller
{
    public $APP_CONSTANT;

    public function __construct()
    {
        $this->APP_CONSTANT = app_constants();
    }


    /**
     * @SWG\Post(
     *   path="/api/driver/status",
     *   summary="update driver's status",
     *      tags={"driver"},
     *   @SWG\Response(
     *     response=200,
     *     description="JWT token to be sent with every request with the user's detail"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="status",
     *     description="0 == offline and 1 == online",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    public function driverStatus(Request $request)
        {
            $app_const = $this->APP_CONSTANT;


                $this->validate($request, [
                    'token' => 'required',
                    'status' => 'required',
                ]);


                Driver::where('api_key', $request->token)->update([
                    'online_status' => $request->status
                ]);

                $driver = Driver::where('api_key', $request->token)->first();

                $transformer = new DriverTransformer();
                $response = [
                    'message' => "Login Successful",
                    'data' => [
                        'token' => $request->api_key,
                        'user' => $transformer->transform($driver)
                    ],
                    'status' => true
                ];


                generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
                return new JsonResponse($response);

           

        }

    /**
     * @SWG\Post(
     *   path="/api/trip/status",
     *   summary="accept or decline a trip",
     *      tags={"driver"},
     *   @SWG\Response(
     *     response=200,
     *     description="Accept or decline a trip"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="trip_id",
     *     description="trip_id",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="status",
     *     description="0 == decline and 1 == accept",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    public function tripStatus(Request $request)
    {
        $app_const = $this->APP_CONSTANT;


        
            $this->validate($request, [
                'token' => 'required',
                'status' => 'required',
                'trip_id' => 'required'
            ]);

            Trip::where('id',$request->trip_id)->update([
                'status' => $request->status
            ]);


            $driver = Driver::where('api_key', $request->token)->first();


            $trip = Trip::where('id',$request->trip_id)->first();

            $user = User::where('id',$trip->user_id)->first();

            $app_const = $this->APP_CONSTANT;
            $transformer = new DriverTransformer();
            $response = [
                'message' => "Trip",
                'data' => [
                    'token' => $request->api_key,
                    'trip' => $trip->toArray(),
                    'user' => $user->toArray()
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);

      

    }
/**
     * @SWG\Post(
     *   path="/api/active/status",
     *   summary="accept or decline a trip",
     *      tags={"driver"},
     *   @SWG\Response(
     *     response=200,
     *     description="Accept or decline a trip"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    public function activeStatus(Request $request)
    {
        $app_const = $this->APP_CONSTANT;


        
            $this->validate($request, [
                'token' => 'required',
            ]);
            $driver = Driver::where('api_key', $request->token)->first();
            

            $trip = Trip::where('driver_id',$driver->id)->where('status',2)->first();
            
            if(!$trip){
                return $response = [
                'message' => "Trip",
                'data' => [
                    'token' => $request->token,
                    'trip' => null
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);
            }
            $user = User::where('id',$trip->user_id)->first();

            $app_const = $this->APP_CONSTANT;
            $transformer = new DriverTransformer();
            $response = [
                'message' => "Trip",
                'data' => [
                    'token' => $request->api_key,
                    'trip' => $trip->toArray(),
                    'user' => $user->toArray()
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);

      

    }

/**
     * @SWG\Post(
     *   path="/api/my/trips",
     *   summary="accept or decline a trip",
     *      tags={"driver"},
     *   @SWG\Response(
     *     response=200,
     *     description="Accept or decline a trip"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    public function myTrips(Request $request)
    {
        $app_const = $this->APP_CONSTANT;


        
            $this->validate($request, [
                'token' => 'required',
            ]);
             $driver = Driver::where('api_key', $request->token)->first();

            $trip = Trip::where('driver_id',$driver->id)->orderby('id','desc')->get();

            
            $app_const = $this->APP_CONSTANT;
            $transformer = new DriverTransformer();
            $response = [
                'message' => "Trip",
                'data' => [
                    'token' => $request->api_key,
                    'trip' => $trip->toArray()
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);

      

    }

}
