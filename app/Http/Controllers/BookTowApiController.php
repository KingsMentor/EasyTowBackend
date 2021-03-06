<?php

namespace App\Http\Controllers;

use App\ApiLog;
use App\Card;
use App\Driver;
use App\DriverTopic;
use App\GCMID;
use App\Topic;
use App\Transformers\CardTransformer;
use App\Transformers\DriverTransformer;
use App\Transformers\UserTransformer;
use App\Trip;
use App\TruckCategoryType;
use App\User;
use Emmanix2002\Moneywave\Moneywave;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;
use LaravelFCM\Message\Topics;



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
        generic_logger("api/onAuthorized", "POST-INTERNAL", [], $request->all());

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
                    'pricing' =>
                        "₦".number_format((double)(distance($request->gps_lat_from,$request->gps_lng_from,$request->gps_lat_to,$request->gps_lng_to,'K')
                                * $type->price_per_km) - 200,0 )." - " ."₦".number_format((double)(
                            (distance($request->gps_lat_from,$request->gps_lng_from,$request->gps_lat_to,$request->gps_lng_to,'K')* $type->price_per_km) + 200),0),
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
            $transformer = new DriverTransformer();


            $driver = Driver::where('api_key',$request->token)->first();

            //send out the broadcast

            $topics = DriverTopic::where('driver_id',$driver->id)->get();
            foreach($topics as $topic){
                $topic_u = Topic::where('id',$topic->topic_id)->first();
                $drivers_on_topic = DriverTopic::where('topic_id',$topic_u->id)->get();
                $driver_i = [];
                foreach ($drivers_on_topic as $d){
                    //driver on a topic
                    $dri = Driver::where('id',$d->id)->first();
                    $driver_i[] = $transformer->transform($dri);
                }


                $dataBuilder = new PayloadDataBuilder();
                $dataBuilder->addData($driver_i);

                $notificationBuilder = new PayloadNotificationBuilder('GPS LOCATION CHANGE');
                $notificationBuilder->setBody('location change')
                    ->setSound('default');

                $notification = $notificationBuilder->build();
                $data = $dataBuilder->build();



                FCM::sendToTopic($topic, null, $notification, $data);

            }

            $app_const = $this->APP_CONSTANT;

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
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="payment_type",
     *     description="cash = 0, card = 1",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="payment_type",
     *     description="cash = 0, card = 1",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="truck_type",
     *     description="the truck type",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
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

        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
        }
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
            

            //create a trip
            $trip = Trip::create([
                'driver_id' => $driver_a->id,
                'user_id' => $user->id,
                'from_gps_lat' => $request->gps_lat_from,
                'from_gps_lng' => $request->gps_lng_from,
                'to_gps_lat' => $request->gps_lat_to,
                'to_gps_lng' => $request->gps_lng_to,
                'payment_type' => $request->payment_type,
                'truck_type' => $request->truck_type,
                'tow_type' => $request->tow_options
            ]);

            //get the push notification id of the driver
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);

            $notificationBuilder = new PayloadNotificationBuilder('Easytow booking');
            $notificationBuilder->setBody("Easy Tow")
                ->setSound("default");

            $dataBuilder = new PayloadDataBuilder();

            $dataBuilder->addData(['to_gps_lat' => $request->gps_lat_to,'from_gps_long' => $request->gps_lng_to,'user' => $user->toArray(),'trip_id' => $trip->id]);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();
            $driver_gcm =  GCMID::where('driver_id',$driver_a->id)->first();
            $token = $driver_gcm->gcm_id;
            try{
                $downstreamResponse = FCM::sendTo($token, $option, null, $data);
            }catch(\Exception $e){
                $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
            }
            sleep(20);

            $trip = Trip::where('id',$trip->id)->first();

            if($trip == "1"){
                $driver_a = $transformer->transform($driver_a);
            }else{
                $driver_a = "";
            }
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


        try {
            $this->validate($request, [
                'gps_lat_from' => 'required',
                'gps_lng_from' => 'required',
            ]);

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }

            $time = time();
            $topic_name = 'topic_location_'.rand(1,9).rand().$time;

            $topic = new Topics();
            $topic->topic($topic_name);

            $db_topic = Topic::create([
                'name' => $topic_name,
                'user_id' => $user->id
            ]);

            $drivers = Driver::geofence($request->gps_lat_from, $request->gps_lng_from, ($request->radius) ? $request->radius : 10, ($request->radius) ? $request->radius + 10 : 50)->where('online_status','1');

            $all = $drivers->get();
            $transformer = new DriverTransformer();
            $drivers_ = [];

            foreach($all as $driver){
                $drivers_[] = $transformer->transform($driver);
                DriverTopic::create([
                    'driver_id' => $driver->id,
                    'topic_id' => $db_topic->id
                ]);
            }


            $app_const = $this->APP_CONSTANT;
            $response = [
                'message' => "Find tow",
                'data' => [
                    'driver' => $drivers_,
                    'topic' => $topic_name
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



    }


    /**
     * @SWG\Post(
     *   path="/api/end/trip",
     *   summary="endtrip",
     *      tags={"booking"},
     *   @SWG\Response(
     *     response=200,
     *     description="find a tow within a location"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=false,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="trip_id",
     *     description="trip_id",
     *     required=false,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */

    public function endtrip(Request $request){


        try {
            $this->validate($request, [
                'token' => 'required',
                'trip_id' => 'required'
            ]);

            $trip = Trip::where('id',$request->trip_id)->first();
            $type = TruckCategoryType::where('id',$trip->tow_type)->first();

            $amount = (double)(distance($trip->from_gps_lat,$trip->from_gps_lng,$request->to_gps_lat,$request->to_gps_lng,'K') * $type->price_per_km);

            if($trip->payment_type == 1){
                $message = "Collect Cash, Card currently not avaliable";
                Trip::where('id',$request->trip_id)->update([
                    'status' => '1',
                    'amount' => $amount
                ]);
                $payment_type = "cash";
            }else{
                $message = "Kindly collect cash from the client";
                Trip::where('id',$request->trip_id)->update([
                    'status' => '1',
                    'amount' => $amount
                ]);
                $payment_type = "cash";
            }


            $app_const = $this->APP_CONSTANT;
            $transformer = new DriverTransformer();
            $response = [
                'message' => "Trip",
                'data' => [
                    'token' => $request->token,
                    'trip' => $trip->toArray(),
                    'amount' => number_format($amount, 0),
                    'payment_type' => $payment_type
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

    }


}
