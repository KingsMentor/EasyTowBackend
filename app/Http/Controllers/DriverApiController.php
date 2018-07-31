<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Transformers\DriverTransformer;
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
     *   summary="Register gps location",
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


            try {
                $this->validate($request, [
                    'token' => 'required',
                    'status' => 'required',
                ]);


                Driver::where('api_key', $request->token)->update([
                    'online_status' => $request->status
                ]);

                $driver = Driver::where('api_key', $request->token)->first();

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

        }



}
