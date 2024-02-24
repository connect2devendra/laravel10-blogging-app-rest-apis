<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        try {
            //fetch all users list
            $users = User::with(['articles'])->get();

            if(count($users) == 0){
               return $this->sendError('User list not found.', [], 404);
            }

            return $this->sendResponse($users->toArray(), 'User list with article details.');

        } catch (\Throwable $th) {
            
            return $this->sendError($th->getMessage(), []);
        }  
    }

    public function update(Request $request, User $user)
    {
        try {
            //update user details
            $inputs = $request->all();

            if(!$user){
                return $this->sendError('User details not found.', [], 404);
            }  

            if(isset($inputs['name']) && !empty($inputs['name'])){
                $user->name = $inputs['name'];
            }

            if(isset($inputs['email']) && !empty($inputs['email'])){
                $user->email = $inputs['email'];
            }

            $user->update();

            return $this->sendResponse($user->toArray(), 'User updated successfully.');

        } catch (\Throwable $th) {
            
            return $this->sendError($th->getMessage(), []);
        }  
    }

    public function destroy($id)
    {
        try {
            //delete user details
            $userDtl = User::find($id);

            if(!$userDtl){
               return $this->sendError('User details not found.', [], 404);
            }

            $userDtl->delete();

            return $this->sendResponse($userDtl->toArray(), 'User deleted successfully.');

        } catch (\Throwable $th) {
            
            return $this->sendError($th->getMessage(), []);
        }  
    }   
    
    
    /**
     * @OA\Get(
     *     path="/api/admin/user",
     *     operationId="authUserDetail",
     *     tags={"Admin.user"},
     *     description="Loggedin User Detail",
     *     @OA\Response(
     *          response=200,
     *          description="LoggedIn User Details.",
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
     *          description="Unauthenticated"
     *      ),
     *     security={{"sanctum":{}}},
     * )
     */
    public function getUserDetails(Request $request)
    {
        try {
                        
            $userDetail = $request->user();

            if($userDetail){
                return $this->sendResponse($userDetail->toArray(), 'Show User Detail.');
            }

            return $this->sendError('User details not found.', [], 404);

        } catch (\Exception $e) {            
            return $this->sendError($e->getMessage(), []);
        }        
    }

    /**
     * @OA\Get(
     *     path="/api/admin/users/{id}",
     *     operationId="show",
     *     tags={"Admin.user"},
     *     description="Loggedin User Detail By Primary ID",
     *     @OA\Parameter(
     *         description="Users table primary ID",
     *         in="path",
     *         name="id",
     *         required=true
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="User Details.",
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
     *          description="Unauthenticated"
     *      ),
     *     security={{"sanctum":{}}},
     * )
     */
    public function show($id)
    {
        try {
                        
            $userDetail = User::find($id);

            if($userDetail !== null){
                return $this->sendResponse($userDetail->toArray(), 'Show User Detail.');
            }

            return $this->sendError('User detail not found.', [], 404);

        } catch (\Throwable $th) {            
            return $this->sendError($th->getMessage(), []);
        }        
    }

    /**
     * @OA\Get(
     *     path="/api/admin/logout",
     *     operationId="logoutUser",
     *     tags={"Admin.user"},
     *     description="Logout user",
     *     @OA\Response(
     *          response=200,
     *          description="Logout Successfully",
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
     *          description="Unauthenticated"
     *      ),
     *     security={{"sanctum":{}}},
     * )
     */
    public function logoutUser()
    {
        try {
                        
             //auth helper function to get login user details
             $user = auth()->user();          

             if($user !== null){
                  // Revoke all tokens...
                  $user->tokens()->delete();
                 return $this->sendResponse($user->toArray(), 'Successfully Logout.');
             }
 
             return $this->sendError('User token already expired.', [], 404);

        } catch (\Throwable $th) {            
            return $this->sendError($th->getMessage(), []);
        }        
    }
    
}
