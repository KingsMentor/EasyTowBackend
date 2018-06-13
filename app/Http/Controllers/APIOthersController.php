<?php

namespace App\Http\Controllers;

use App\ApiLog;
use App\GCMID;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class APIOthersController extends ApiBaseController
{

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
}
