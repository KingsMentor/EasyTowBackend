<?php

namespace App\Http\Controllers;

use App\Address;
use App\Driver;
use App\Transformers\AddressTransformer;
use App\Transformers\DriverTransformer;
use App\Transformers\UserTransformer;
use App\Transformers\VehicleTransformer;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Sodium\crypto_box_publickey_from_secretkey;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;

class APIAuthenticateController extends ApiBaseController
{
    /**
     * @SWG\Swagger(
     *     schemes={"http"},
     *     host="easytow.test",
     *     basePath="/",
     *     @SWG\Info(
     *         version="1.0.0",
     *         title="Swagger Mobile api",
     *         description="Api description...",
     *         termsOfService="",
     *     ),
     *     @SWG\ExternalDocumentation(
     *         description="Find out more about my website",
     *         url="https..."
     *     )
     * )
     */
    public function __construct(Request $req)
    {

        parent::__construct();
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        JWTAuth::invalidate($request->input('token'));
        return response()->json(['success' => 'Log out successful'], 200);
    }


    /**
     * @SWG\Post(
     *   path="/api/auth/login",
     *     tags={"user"},
     *   summary="Logs the user in and sends JWT token to be sent with every request with the user's detail",
     *   @SWG\Response(
     *     response=200,
     *     description="authorization token with user's data"
     *   ),
     *   @SWG\Parameter(
     *     name="phone",
     *     description="User's phone number",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *     @SWG\Parameter(
     *     name="password",
     *     description="User's password",
     *     required=true,
     *     in="formData",
     *     type="string"
     * )
     * )
     */
    public function postLogin(Request $request)
    {
        $app_const = $this->APP_CONSTANT;
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|max:255',
                'password' => 'required',
            ]);


            if ($validator->fails())
                throw new ValidationException($validator->errors());


            // Attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt(['phone_no' => $request->phone,'password' => $request->password,'type' => "4"])) {
                return $this->onUnauthorized();
            }

            // All good so return the token

            return $this->onAuthorized($token);
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
     *   path="/api/auth/sign-up",
     *   summary="Register a new user",
     *      tags={"user"},
     *   @SWG\Response(
     *     response=200,
     *     description="JWT token to be sent with every request with the user's detail"
     *   ),
     *   @SWG\Parameter(
     *     name="first_name",
     *     description="User's first name",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="last_name",
     *     description="User's last name",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="email",
     *     description="User's email address",
     *     required=false,
     *     in= "formData",
     *     type="string"
     * ),
     *     @SWG\Parameter(
     *     name="password",
     *     description="User's password",
     *     required=false,
     *     in="formData",
     *     type="string"
     * ),
     * @SWG\Parameter(
     *     name="phone_no",
     *     description="User's phone number",
     *     required=false,
     *     in="formData",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="social_id",
     *     description="Social Id",
     *     required=false,
     *     in="formData",
     *     type="string"
     * )
     * )
     */
    public function sign_up(Request $request)
    {
        $app_const = $this->APP_CONSTANT;
        try {
            $this->validate($request, [
                'email' => 'email|max:255',
                'first_name' => 'required',
                'last_name' => 'required',
            ]);

            $requestArray = $request->all();
            if(isset($requestArray['password'])) {
                $requestArray['password'] = \app('hash')->make($request->password);
            }

            //check if phone exist
            if(isset($requestArray['phone_no'])) {
                $user = User::where('phone_no',$requestArray['phone_no'])->where('type','4')->first();
                if($user){
                    return genericResponse("Phone Number already exist", '404', $request);
                }
            }

            if(isset($requestArray['email'])) {
                $user = User::where('email',$requestArray['email'])->where('type','4')->first();
                if($user){
                    return genericResponse("Email already exist", '404', $request);
                }
            }

            $requestArray['type'] = "4";

            User::create($requestArray);


            // Attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt(['phone_no' => $request->phone_no,'password' => $request->password])) {
                return genericResponse($app_const["TOKEN_CREATION_ERR"], "404", $request);
            }

        } catch (ValidationException $e) {
            return genericResponse($app_const['REG_VALIDATION_EXCEPTION'], '404', $request);

        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            return genericResponse($app_const["TOKEN_CREATION_ERR"], "404", $request);


        }

        // All good so return the token
        return $this->onAuthorized($token);
    }


    /**
     * What response should be returned on invalid credentials.
     *
     * @return JsonResponse
     */

    /**
     * What response should be returned on error while generate JWT.
     *
     * @return JsonResponse
     */


    /**
     * What response should be returned on authorized.
     *
     * @return JsonResponse
     */
    protected function onAuthorized($token)
    {
        $app_const = $this->APP_CONSTANT;
        $transformer = new UserTransformer();
        $response = [
            'message' => $app_const['TOKEN_GEN'],
            'data' => [
                'token' => $token,
                'user' => $transformer->transform($this->user())
            ],
            'status' => true
        ];


        generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
        return new JsonResponse($response);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */


    /**
     * Invalidate a token.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Delete(
     *   path="/api/auth/invalidate",
     *   summary="Invalidate/Delete user authorization token using previous token",
     *      tags={"user"},
     *   @SWG\Response(
     *     response=200,
     *     description="success message"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="authorization token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function deleteInvalidate(Request $request)
    {

        $app_const = $this->APP_CONSTANT;
        try {

            $token = JWTAuth::parseToken();

            $token->invalidate();

            return validResponse($app_const['TOKEN_INVALIDATED'], [], $request);

        } catch (TokenBlacklistedException $e) {
            return validResponse($app_const['TOKEN_INVALIDATED'], [], $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }
    }


    /**
     * change member password.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Post(
     *   path="/api/auth/change-password",
     *   summary="change member password",
     *      tags={"user"},
     *   @SWG\Response(
     *     response=200,
     *     description="success message"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="authorization token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="old_password",
     *     description="old password",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="password",
     *     description="new password",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function change_password(Request $request)
    {
        $app_const = $this->APP_CONSTANT;
        try {
            $this->validate($request, [
                'password' => 'required',
                'old_password' => 'required',
            ]);

            if (Hash::check($request->old_password, $this->user()->password)) {
                User::where('id', $this->auth()->user()->id)->update(['password' => \app('hash')->make($request->password)]);
                return validResponse($app_const['PASSWORD_CHANGE_SUCCESSFUL'], [], $request);

            } else {
                return genericResponse($app_const["INVALID_OLD_PASSWORD"], '401', $request);
            }

        } catch (ValidationException $e) {
            return genericResponse($app_const['VALIDATION_EXCEPTION'], $app_const['VALIDATION_EXCEPTION_CODE'], $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }


    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Patch(
     *   path="/api/auth/refresh",
     *   summary="Refresh user authorization token details using previous token",
     *      tags={"user"},
     *   @SWG\Response(
     *     response=200,
     *     description="new authorization token"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="authorization token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function patchRefresh(Request $request)
    {
        $app_const = $this->APP_CONSTANT;
        try {
            $token = JWTAuth::parseToken();

            $newToken = $token->refresh();

            return validResponse($app_const['TOKEN_REFRESHED'], [
                'token' => $newToken
            ], $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }
    }


    /**
     * Get authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Get(
     *   path="/api/auth/user",
     *   summary="Get logged in user details using token gotten from login",
     *      tags={"user"},
     *   @SWG\Response(
     *     response=200,
     *     description="user's data"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="authorization token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function getUser(Request $request)
    {
        $app_const = $this->APP_CONSTANT;
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }

            $transformer = new UserTransformer();

            return validResponse($app_const['MEMBER'], $transformer->transform($this->user()), $request);


        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return genericResponse($app_const["TOKEN_INVALIDATED"], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return genericResponse($app_const['TOKEN_INVALID'], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return genericResponse($app_const['EXCEPTION'], "500", $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }

    }

    /**
     * @SWG\Post(
     *   path="/api/auth/send-password-reset-link",
     *   summary="send password reset link to email",
     *      tags={"user"},
     *   @SWG\Response(
     *     response=200,
     *     description="returns status: true if valid otherwise false and message"
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     description="user's email",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */

    public function send_password_reset_link(Request $request)
    {
        $app_const = $this->APP_CONSTANT;
        try {


            $this->validate($request, [
                'email' => 'required|exists:users,email',
            ]);

            $mem = User::where('email', $request->email)->first();


            $message = " Click the link below to go to your reset password page <br /> <br />  <a href='" . getResetPasswordURL($request->email) . encrypt_decrypt('encrypt', $mem->id) . "'> Click  </a>  <br /> <br />  Or copy this like to your browser " . getResetPasswordURL($request->email) . encrypt_decrypt('encrypt', $mem->id) . " ";


            sendEmail(
                $message,
                'Password Reset',
                "{$app_const['EMAIL_FROM']}", $request->email);


            return validResponse($app_const['RESET_EMAIL_SENT'], [], $request);


        } catch (ValidationException $e) {
            return genericResponse($app_const['INVALID_EMAIL_EXCEPTION'], '404', $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/auth/update/profile",
     *   summary="send password reset link to email",
     *      tags={"user"},
     *   @SWG\Response(
     *     response=200,
     *     description="returns status: true if valid otherwise false and message"
     *   ),
     *      @SWG\Parameter(
     *     name="first_name",
     *     description="first name",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),@SWG\Parameter(
     *     name="last_name",
     *     description="last name",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="email",
     *     description="user's email",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="phone_no",
     *     description="user's phone",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="password",
     *     description="user's password",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="token",
     *     description="authorization token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */

    public function update_profile(Request $request){

        $app_const = $this->APP_CONSTANT;
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }

            $request_data = $request->all();
            if(isset($request_data['password'])){
                $request_data['password'] = Hash::make($request_data['password']);
            }
            unset($request_data['token']);

            User::where('id',$user->id)->update($request_data);

            $user = User::where('id',$user->id)->first();

            $transformer = new UserTransformer();

            return validResponse($app_const['MEM_PROFILE_UPDATED'], $transformer->transform($user), $request);


        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return genericResponse($app_const["TOKEN_INVALIDATED"], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return genericResponse($app_const['TOKEN_INVALID'], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return genericResponse($app_const['EXCEPTION'], "500", $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }

    }


    /**
     * @SWG\Post(
     *   path="/api/driver/login",
     *     tags={"driver"},
     *   summary="Logs the user in and sends JWT token to be sent with every request with the user's detail",
     *   @SWG\Response(
     *     response=200,
     *     description="authorization token with user's data"
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     description="User's email address",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *     @SWG\Parameter(
     *     name="password",
     *     description="User's password",
     *     required=true,
     *     in="formData",
     *     type="string"
     * )
     * )
     */
    public function driverLogin(Request $request)
    {
        $app_const = $this->APP_CONSTANT;
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);


            if ($validator->fails())
                throw new ValidationException($validator->errors());


            // Attempt to verify the credentials and create a token for the user
            if (!$token = auth()->guard('drivers')->attempt(['email' => $request->email,'password' => $request->password])) {
                return $this->onUnauthorized();
            }

            // All good so return the token

            $app_const = $this->APP_CONSTANT;
            $transformer = new DriverTransformer();
            $response = [
                'message' => "Login Successful",
                'data' => [
                    'token' => auth()->guard('drivers')->user()->api_key,
                    'user' => $transformer->transform(auth()->guard('drivers')->user())
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
     *   path="/api/driver/sign-up",
     *   summary="Register a new user",
     *      tags={"driver"},
     *   @SWG\Response(
     *     response=200,
     *     description="JWT token to be sent with every request with the user's detail"
     *   ),
     *   @SWG\Parameter(
     *     name="name",
     *     description="User's full name",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="email",
     *     description="User's email address",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *     @SWG\Parameter(
     *     name="password",
     *     description="User's password",
     *     required=true,
     *     in="formData",
     *     type="string"
     * ),
     *  @SWG\Parameter(
     *     name="phone_no",
     *     description="User's phoneno",
     *     required=true,
     *     in="formData",
     *     type="string"
     * )
     * )
     */



    public function driver_sign_up(Request $request)
    {
        $app_const = $this->APP_CONSTANT;
        try {
            $this->validate($request, [
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required',
                'name' => 'required'
            ]);

            $requestArray = $request->all();

            $requestArray['password'] = \app('hash')->make($request->password);

            $requestArray['api_key'] = $this->generateRandomString(50);

            $driver = Driver::create($requestArray);


            auth()->guard('drivers')->loginUsingId($driver->id);

            // All good so return the token

            $app_const = $this->APP_CONSTANT;
            $transformer = new DriverTransformer();
            $response = [
                'message' => "Signup successful",
                'data' => [
                    'token' => auth()->guard('drivers')->user()->api_key,
                    'user' => $transformer->transform(auth()->guard('drivers')->user())
                ],
                'status' => true
            ];


        } catch (ValidationException $e) {
            return genericResponse($app_const['REG_VALIDATION_EXCEPTION'], '404', $request);

        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            return genericResponse($app_const["TOKEN_CREATION_ERR"], "404", $request);


        }

        generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
        return new JsonResponse($response);
    }



    /**
     * @SWG\Post(
     *   path="/api/delete/account",
     *   summary="Delete account",
     *   tags={"user"},
     *   @SWG\Response(
     *     response=200,
     *     description="returns status: true if valid otherwise false and message"
     *   ),
     *    @SWG\Parameter(
     *     name="token",
     *     description="authorization token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function deleteUser(Request $request){
        $app_const = $this->APP_CONSTANT;
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }


            User::where('id', $user->id)->delete();


            return validResponse('ADDRESS DELETED', [], $request);


        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return genericResponse($app_const["TOKEN_INVALIDATED"], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return genericResponse($app_const['TOKEN_INVALID'], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return genericResponse($app_const['EXCEPTION'], "500", $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/add/vehicle",
     *   summary="add Vechile",
     *      tags={"vehicle"},
     *   @SWG\Response(
     *     response=200,
     *     description="JWT token to be sent with every request with the user's detail"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *   @SWG\Parameter(
     *     name="name",
     *     description="name",
     *     required=true,
     *     in= "formData",
     *     type="string"
     * ),
     *     @SWG\Parameter(
     *     name="plate_no",
     *     description="plate_no",
     *     required=true,
     *     in="formData",
     *     type="string"
     * ),
     *     @SWG\Parameter(
     *     name="type",
     *     description="type",
     *     required=true,
     *     in="formData",
     *     type="string"
     * )
     * )
     */
    public function addVehicle(Request $request){
        $app_const = $this->APP_CONSTANT;
        try {
            $this->validate($request,[
                'name' => 'required',
                'plate_no' => 'required|unique:vehicles',
                'type' => 'required'
            ]);
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }


            $vehicles = Vehicle::where('user_id',$user->id)->get();

            $vehic_transform = new VehicleTransformer();

            $t = [];
            foreach($vehicles as $vehice){
                $t[] = $vehic_transform->transform($vehice);
            }

            if($vehicles->count() == 0){
                $option = "1";
            }else{
                $option = "0";
            }


            $vehicle = Vehicle::create([
                'manufacturer' => $request->name,
                'plate_no' => $request->plate_no,
                'type_id' => $request->type,
                'user_id' => $user->id,
                'default' => $option
            ]);


            $response = [
                'message' => "vehicle",
                'data' => [
                    'vehicle' => $vehic_transform->transform($vehicle),
                    'vehicles' => $t
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);



        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return genericResponse($app_const["TOKEN_INVALIDATED"], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return genericResponse($app_const['TOKEN_INVALID'], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return genericResponse($app_const['EXCEPTION'], "500", $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }
    }


    /**
     * @SWG\Post(
     *   path="/api/vehicles",
     *   summary="add Vechile",
     *      tags={"vehicle"},
     *   @SWG\Response(
     *     response=200,
     *     description="JWT token to be sent with every request with the user's detail"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function vehicles(Request $request){
        $app_const = $this->APP_CONSTANT;
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }

            $vehicles = Vehicle::where('user_id',$user->id)->get();
            $vehic_transform = new VehicleTransformer();
            $t = [];
            foreach($vehicles as $vehicle){
                $t[] = $vehic_transform->transform($vehicle);
            }


            $response = [
                'message' => "vehicles",
                'data' => [
                    'vehicle' => $t
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);



        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return genericResponse($app_const["TOKEN_INVALIDATED"], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return genericResponse($app_const['TOKEN_INVALID'], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return genericResponse($app_const['EXCEPTION'], "500", $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }
    }


    /**
     * @SWG\Post(
     *   path="/api/vehicle/default",
     *   summary="Set Vehicle Default",
     *      tags={"vehicle"},
     *   @SWG\Response(
     *     response=200,
     *     description="JWT token to be sent with every request with the user's detail"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="vehicle_id",
     *     description="Vehicle id",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function set_vehicle_default(Request $request){
        $app_const = $this->APP_CONSTANT;
        try {
            $t = [];
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }

            $this->validate($request,[
                'vehicle_id' => 'required'
            ]);


            $vehicles = Vehicle::where('user_id',$user->id)->get();

            foreach($vehicles as $veh){
                if($veh->id == $request->vehicle_id){
                    Vehicle::where('id', $veh->id)->update([
                        'default' => 1
                    ]);
                }else {
                    Vehicle::where('id', $veh->id)->update([
                        'default' => 0
                    ]);
                }
            }

            $vehic_transform = new VehicleTransformer();

            $vehicle = Vehicle::where('id',$request->vehicle_id)->where('user_id',$user->id)->first();


            $t[] = $vehic_transform->transform($vehicle);


            $response = [
                'message' => "default vehicle has been set",
                'data' => [
                    'vehicle' => $t
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);



        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return genericResponse($app_const["TOKEN_INVALIDATED"], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return genericResponse($app_const['TOKEN_INVALID'], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return genericResponse($app_const['EXCEPTION'], "500", $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }
    }


    /**
     * @SWG\Delete(
     *   path="/api/delete/vehicle",
     *   summary="Delete Vehicle",
     *      tags={"vehicle"},
     *   @SWG\Response(
     *     response=200,
     *     description="JWT token to be sent with every request with the user's detail"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     description="token",
     *     required=true,
     *     in= "query",
     *     type="string"
     * ),
     *    @SWG\Parameter(
     *     name="vehicle_id",
     *     description="Vehicle id",
     *     required=true,
     *     in= "query",
     *     type="string"
     * )
     * )
     */
    public function delete_vehicle(Request $request){
        $app_const = $this->APP_CONSTANT;
        try {
            $t = [];
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return genericResponse($app_const["MEMBER_NOT_FOUND"], 404, $request);
            }

            $this->validate($request,[
                'vehicle_id' => 'required'
            ]);


            $vehicle = Vehicle::where('id',$request->vehicle_id)->first();
            Vehicle::where('id',$request->vehicle_id)->delete();


            $vehic_transform = new VehicleTransformer();

            $t[] = $vehic_transform->transform($vehicle);


            $response = [
                'message' => "Vehicle has been deleted",
                'data' => [
                    'vehicle' => $t
                ],
                'status' => true
            ];


            generic_logger("api/onAuthorized", "POST-INTERNAL", [], $response);
            return new JsonResponse($response);



        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return genericResponse($app_const["TOKEN_INVALIDATED"], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return genericResponse($app_const['TOKEN_INVALID'], '401', $request);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return genericResponse($app_const['EXCEPTION'], "500", $request);
        } catch (\Exception $e) {
            return genericResponse($app_const['EXCEPTION'], $app_const['EXCEPTION_CODE'], $request, ['message' => $e, 'stack_trace' => $e->getTraceAsString()]);
        }
    }

}
