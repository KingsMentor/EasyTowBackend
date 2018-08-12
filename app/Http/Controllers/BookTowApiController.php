<?php

namespace App\Http\Controllers;

use App\ApiLog;
use App\Card;
use App\Driver;
use App\GCMID;
use App\Transformers\CardTransformer;
use App\Transformers\DriverTransformer;
use App\Transformers\UserTransformer;
use App\TruckCategoryType;
use App\User;
use Emmanix2002\Moneywave\Moneywave;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class BookTowApiController extends ApiBaseController
{

    public $moneywave;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @SWG\Post(
     *   path="/api/get/tow/option",
     *     tags={"user"},
     *   summary="This api would be use to calculate the base fare and determine what works",
     *   @SWG\Response(
     *     response=200,
     *     description="check if phone number exist"
     *   ),
     *   @SWG\Parameter(
     *     name="gps_lat_from",
     *     description="GPS latitude From ",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="gps_lng_from",
     *     description="GPS Longitude From",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="gps_lat_to",
     *     description="GPS latitude to",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="gps_lng_to",
     *     description="GPS Longitude To",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    //check phone number if it exists
    public function getTowOption(Request $request){
        $app_const = $this->APP_CONSTANT;
        $phone = false;
        $message = "Getting price range per km";
        $pricing_calculation = [];
        try {
            $this->validate($request, [
                'gps_lat_from' => 'required',
                'gps_lng_from' => 'required',
                'gps_lat_to' => 'required',
                'gps_lng_to' => 'required'
            ]);

            $app_const = $this->APP_CONSTANT;

            $truck_category_types = TruckCategoryType::all();

            foreach($truck_category_types as $type){
                $pricing_calculation[] = [
                    'id' => $type->id,
                    'name' => $type->name,
                    'pricing' => number_format(distance($request->gps_lat_from,$request->gps_lng_from,$request->gps_lat_to,$request->gps_lng_to,'K') * $type->price_per_km,0)
                ];
            }


            $response = [
                'message' => $message,
                'data' =>  $pricing_calculation,
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);

        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            return $this->onJwtGenerationError();

        } catch (ValidationException $e) {
            return genericResponse($app_const['VALIDATION_EXCEPTION'], $app_const['VALIDATION_EXCEPTION_CODE'], $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], '500', $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }


        generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
        return new JsonResponse($response);
    }



    /**
     * @SWG\Post(
     *   path="/api/update/gps",
     *   summary="Register gps location",
     *      tags={"booking"},
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
     *     name="gps_lat",
     *     description="gps_lat",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *     @SWG\Parameter(
     *     name="gps_lon",
     *     description="gps_lat",
     *     required=true,
     *     in="formData",
     *     type="string"
     * )
     * )
     */
    public function updateGPS(Request $request)
    {
        $app_const = $this->APP_CONSTANT;


        try {
            $this->validate($request, [
                'token' => 'required',
                'gps_lat' => 'required',
                'gps_lon' => 'required',
            ]);

            Driver::where('api_key',$request->token)->update([
                'latitude' => $request->gps_lat,
                'longitude' => $request->gps_lon
            ]);

            $driver = Driver::where('api_key',$request->token)->first();

            $app_const = $this->APP_CONSTANT;
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

        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            return $this->onJwtGenerationError();

        } catch (ValidationException $e) {
            return genericResponse($app_const['VALIDATION_EXCEPTION'], $app_const['VALIDATION_EXCEPTION_CODE'], $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], '500', $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }


        generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
        return new JsonResponse($response);
    }

    /**
     * @SWG\Post(
     *   path="/api/find/tow",
     *   summary="Register gps location",
     *      tags={"booking"},
     *   @SWG\Response(
     *     response=200,
     *     description="find a tow within a location"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="gps_lat_from",
     *     description="GPS latitude From ",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="gps_lng_from",
     *     description="GPS Longitude From",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="gps_lat_to",
     *     description="GPS latitude to",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="gps_lng_to",
     *     description="GPS Longitude To",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="tow_options",
     *     description="tow_option",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="vehicle_id",
     *     description="vehicle option",
     *     required=false,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="radius",
     *     description="radius",
     *     required=false,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */

    public function find_tow(Request $request){
        $app_const = $this->APP_CONSTANT;


//        try {
            $this->validate($request, [
                'gps_lat_from' => 'required',
                'gps_lng_from' => 'required',
                'gps_lat_to' => 'required',
                'gps_lng_to' => 'required',
                'tow_options' => 'required'
            ]);

            $drivers = Driver::geofence($request->gps_lat_from, $request->gps_lng_from, ($request->radius) ? $request->radius : 10, ($request->radius) ? $request->radius + 20 : 50)->where('online_status','1');

            $all = $drivers->get();

            $transformer = new DriverTransformer();
            $drivers_ = [];


            foreach($all as $key => $driver){
                $drivers_[] = $driver;
            }

            if(!empty($drivers_)) {
                $driver_key = array_rand($drivers_);

                $driver_a = Driver::where('id', $drivers_[$driver_key]->id)->first();
                $driver_a = $transformer->transform($driver_a);
            }else{
                $driver_a = null;
            }
            $app_const = $this->APP_CONSTANT;
            $response = [
                'message' => "Find a tow",
                'data' => [
                    'driver' => $driver_a
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);

//        } catch (JWTException $e) {
//            // Something went wrong whilst attempting to encode the token
//            return $this->onJwtGenerationError();
//
//        } catch (ValidationException $e) {
//            return genericResponse($app_const['VALIDATION_EXCEPTION'], $app_const['VALIDATION_EXCEPTION_CODE'], $request);
//        } catch (\Exception $e) {
//            return genericResponse($app_const['EXCEPTION'], '500', $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
//        }




    }



    /**
     * @SWG\Post(
     *   path="/api/list/driver",
     *   summary="Register gps location",
     *      tags={"booking"},
     *   @SWG\Response(
     *     response=200,
     *     description="find a tow within a location"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="gps_lat_from",
     *     description="GPS latitude From ",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="gps_lng_from",
     *     description="GPS Longitude From",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="radius",
     *     description="Radius",
     *     required=false,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */

    public function list_drivers(Request $request){
        $app_const = $this->APP_CONSTANT;


//        try {
            $this->validate($request, [
                'gps_lat_from' => 'required',
                'gps_lng_from' => 'required',
            ]);

            $drivers = Driver::geofence($request->gps_lat_from, $request->gps_lng_from, ($request->radius) ? $request->radius : 10, ($request->radius) ? $request->radius + 10 : 50)->where('online_status','1');

            $all = $drivers->get();
            $transformer = new DriverTransformer();
            $drivers_ = [];

            foreach($all as $driver){
                $drivers_[] = $transformer->transform($driver);
            }


            $app_const = $this->APP_CONSTANT;
            $response = [
                'message' => "Find tow",
                'data' => [
                    'driver' => $drivers_
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);

//        } catch (JWTException $e) {
//            // Something went wrong whilst attempting to encode the token
//            return $this->onJwtGenerationError();
//
//        } catch (ValidationException $e) {
//            return genericResponse($app_const['VALIDATION_EXCEPTION'], $app_const['VALIDATION_EXCEPTION_CODE'], $request);
//        } catch (\Exception $e) {
//            return genericResponse($app_const['EXCEPTION'], '500', $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
//        }



    }


}
