<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
     /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="authLogin",
     *     tags={"Authenticate"},
     *     summary="Authenticate user and generate JWT token",     
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(
     *              type="string",
     *              example="admin@test.com"
     *          )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(
     *              type="string",
     *              example="admin123"
     *          )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *      @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=401, 
     *          description="Invalid credentials"
     *      ),
     * )
     */
    public function login(Request $request)
    {
        try {

            $inputs = $request->all();

              //Validated
              $validator = Validator::make($inputs,
              [
                  'email' => 'required|email',
                  'password' => 'required'
              ]);
  
              if($validator->fails()){
                // return $this->sendError('Validation Error.', $validator->errors()->all(),422);
                return $this->sendError('Validation Error.', $validator->errors(), 422);
              }

              $credentials = $request->only('email', 'password');

              if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('api_token')->plainTextToken;

                  return $this->sendResponse(['user'=>$user, 'token' => $token], 'Login successfully.');
              }
              return $this->sendError('Invalid credentials', [], 401);  
            
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }       
    }


     /**
     * @OA\Post(
     *     path="/api/register",
     *     operationId="authRegister",
     *     tags={"Authenticate"},
     *     summary="Register a new user",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         required=true,
     *         @OA\Schema(
     *              type="string",
     *              default="Devendra Kumar"
     *          )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(
     *              type="string",
     *              default="admin@test.com"
     *          )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(
     *              type="string",
     *              default="admin123"
     *          )
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Register Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *      @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function register(Request $request)
    {
        try {

            $inputs = $request->all();

             //Validated
             $validator = Validator::make($inputs, 
             [
                 'name' => 'required|string|max:60',
                 'email' => 'required|email|unique:users,email',
                 'password' => 'required|string|min:8'
             ]);
 
             if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors(),422); 
             }

             $user = User::create([
                'name' => $inputs['name'],
                'email' => $inputs['email'],
                'password' => Hash::make($inputs['password']),
            ]);
    
            return $this->sendResponse($user->toArray(), 'User registered successfully.', 201);
            
        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), []);             
        }    
        
    }
    
}
