<?php

namespace App\Http\Controllers;

use App\ApiLog;
use App\Card;
use App\GCMID;
use App\Transformers\CardTransformer;
use App\Transformers\UserTransformer;
use App\User;
use Emmanix2002\Moneywave\Moneywave;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class APIOthersController extends ApiBaseController
{

    public $moneywave;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @SWG\Post(
     *   path="/api/check/phone",
     *     tags={"user"},
     *   summary="checking if a phone number exist",
     *   @SWG\Response(
     *     response=200,
     *     description="check if phone number exist"
     *   ),
     *   @SWG\Parameter(
     *     name="phone",
     *     description="phone number field",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    //check phone number if it exists
    public function checkPhoneNo(Request $request){
        $app_const = $this->APP_CONSTANT;
        $phone = false;
        $message = "phone number doesn't exist";

        try {
            $this->validate($request, [
                'phone' => 'required'
            ]);

            $app_const = $this->APP_CONSTANT;

            $user = User::where('phone_no',$request->phone)->where('type','4')->first();

            if($user){
                $phone = true;
                $message = "phone number exist";
            }

            $response = [
                'message' => $message,
                'data' => [
                    'phone' => $phone
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
     *   path="/api/check/email",
     *     tags={"user"},
     *   summary="checking if an email exist",
     *   @SWG\Response(
     *     response=200,
     *     description="check if email exist"
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     description="Email field",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    public function checkEmail(Request $request){
        $app_const = $this->APP_CONSTANT;
        $email = false;
        $message = "Email doesn't exist";

        try {
            $this->validate($request, [
                'email' => 'required'
            ]);

            $app_const = $this->APP_CONSTANT;

            $user = User::where('email',$request->email)->where('type','4')->first();

            if($user){
                $email = true;
                $message = "Email exist";
            }

            $response = [
                'message' => $message,
                'data' => [
                    'email' => $email
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
     *   path="/api/update/gcm",
     *     tags={"user"},
     *   summary="checking if an email exist",
     *   @SWG\Response(
     *     response=200,
     *     description="check if email exist"
     *   ),
     *    @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="gcm_id",
     *     description="gcm_id field",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    public function updateGCMIDS(Request $request){
        $app_const = $this->APP_CONSTANT;

        try {
            $gcm_id =  $request->gcm_id;
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }


                /// check if gcm exist aready
                $OLD_gcm = GCMID::where('user_id',$user->id)->first();
                if($OLD_gcm)
                {
                    GCMID::where('user_id',$user->id)->update(['gcm_id' => $gcm_id]);
                }else{
                    GCMID::create(['user_id'=>$user->id,'gcm_id'=>$gcm_id]);
                }



            $data = [
                'message' => "GCM ID has been saved successfully",
                'data' => [
                    'gcm' => $request->gcm_id
                ],
                'status' => true
            ];
            return validResponse("Update successfully" , $data, $request);


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
     *   path="/api/check/socialId",
     *     tags={"user"},
     *   summary="checking if an email exist",
     *   @SWG\Response(
     *     response=200,
     *     description="check if email exist"
     *   ),
     *   @SWG\Parameter(
     *     name="social_id",
     *     description="social id field",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    public function check_social_id(Request $request){
        $app_const = $this->APP_CONSTANT;
        $email = false;
        $message = "Social Id doesn't exist";

        try {
            $this->validate($request, [
                'social_id' => 'required'
            ]);

            $app_const = $this->APP_CONSTANT;

            $user = User::where('social_id',$request->social_id)->first();

            if($user){
                $email = true;
                $message = "Social Id exist";
            }

            $response = [
                'message' => $message,
                'data' => [
                    'social_id' => $email
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
     *   path="/api/add/card",
     *     tags={"payment"},
     *   summary="checking if a phone number exist",
     *   @SWG\Response(
     *     response=200,
     *     description="check if phone number exist"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token of user",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="card_no",
     *     description="Card_no",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *     @SWG\Parameter(
     *     name="cvv",
     *     description="cvv",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="expiry_year",
     *     description="Expiry year",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="expiry_month",
     *     description="Expiry month",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */
    //check phone number if it exists
    public function addCard(Request $request){
        $app_const = $this->APP_CONSTANT;

//        try {

            $accessToken = !empty(session('accessToken')) ? session('accessToken') : null;
            $this->moneywave = new Moneywave($accessToken);
            session(['accessToken' => $this->moneywave->getAccessToken()]);

            $this->validate($request, [
                'card_no' => 'required',
                'cvv' => 'required',
                'expiry_year' => 'required',
                'expiry_month' => 'required',
            ]);

            $card = $this->moneywave->createCardTokenizationService();
            $card->card_no = $request->card_no;
            $card->cvv = $request->cvv;
            $card->expiry_year = $request->expiry_year;
            $card->expiry_month = $request->expiry_month;
            $response = $card->send();
            $data = $response->getData();

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }
            $card_no = str_pad(substr($data['cardToken'], -4), strlen($data['cardToken']), '*', STR_PAD_LEFT);

            User::where('id',$user->id)->update([
                'access_code' => $data['cardToken'],
                'card_no' => $card_no
            ]);

            $card = Card::where('user_id',$user->id)->where('access_token',$data['cardToken'])->first();
            if(!$card){
               $card = Card::create([
                        'user_id' => $user->id,
                        'access_token' => $data['cardToken'],
                        'card_no' => $card_no
                ]);
            }

            $user_transform = new UserTransformer();
            $response = [
                'message' => "Card has been added",
                'data' => [
                    'card_no' => $card_no,
                    'card_id' => $card->id,
                    'user' => $user_transform->transform($user)
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


        generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
        return new JsonResponse($response);
    }

    /**
     * @SWG\Post(
     *   path="/api/delete/card",
     *     tags={"payment"},
     *   summary="checking if a phone number exist",
     *   @SWG\Response(
     *     response=200,
     *     description="check if phone number exist"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token of user",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="id",
     *     description="id",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */

    public function deleteCard(Request $request){
        $app_const = $this->APP_CONSTANT;

        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }
            $card = Card::where('id',$request->id)->first();

            if($card->default == "0") {

                Card::where('id', $request->id)->delete();


                $user_transform = new UserTransformer();
                $response = [
                    'message' => "Card has been deleted",
                    'data' => [
                        'card_no' => null,
                        'user' => $user_transform->transform($user)
                    ],
                    'status' => true
                ];
            }else{

                $user_transform = new UserTransformer();
                $response = [
                    'message' => "Card cannot be deleted",
                    'data' => [
                        'card_no' => $card->card_no,
                        'user' => $user_transform->transform($user)
                    ],
                    'status' => true
                ];
            }


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
     *   path="/api/card/default",
     *     tags={"payment"},
     *   summary="make a card the default",
     *   @SWG\Response(
     *     response=200,
     *     description="check if phone number exist"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token of user",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="id",
     *     description="id",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * )
     * )
     */


    public function makeDefault(Request $request){
        $app_const = $this->APP_CONSTANT;

        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }
            $card = Card::where('id',$request->id)->first();

            Card::where('user_id', $card->user_id)->update([
                'default' => '0'
            ]);


            Card::where('id', $request->id)->update([
                'default' => '1'
            ]);


            $user_transform = new UserTransformer();
            $response = [
                'message' => "Card has been selected as the default card",
                'data' => [
                    'card_no' => $card->card_no,
                    'user' => $user_transform->transform($user)
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
     *   path="/api/my/card",
     *     tags={"payment"},
     *   summary=" get a user's cards",
     *   @SWG\Response(
     *     response=200,
     *     description="cards"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token of user",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function allCards(Request $request){
        $app_const = $this->APP_CONSTANT;

        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }
            $cards = Card::where('id',$user->id)->get();
            $tr_card = new CardTransformer();
            $c_i = [];

            foreach($cards as $card){
                $c_i[] = $tr_card->transform($card);
            }


            $user_transform = new UserTransformer();
            $response = [
                'message' => "All cards",
                'data' => [
                    'cards' => $c_i,
                    'user' => $user_transform->transform($user)
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



}
