<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\RegisterResource;
use Illuminate\Support\Carbon;

class RegisterController extends BaseController
{
    public $expiration; // define the public variable here

    public function __construct()
    {
        $this->expiration = Carbon::now()->addDays(7); // set the value for $expiration in the constructor
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken($user->name, ['*'], $this->expiration)->plainTextToken;
        $success['name'] =  $user->name;

        // return $this->sendResponse($success, 'User register successfully.');
        return $this->sendResponse(new RegisterResource($success), 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], true)){
            $user = Auth::user();
            $success['token'] = $user->createToken($user->name, ['*'], $this->expiration)->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse(new RegisterResource($success), 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();
        if ($user && $user->tokens()->where('id', $user->currentAccessToken()->id)->exists()) {
            $user->tokens()->delete();
            return $this->sendResponse(null, 'User logout successfully.');
        } else {
            return $this->sendError('Unauthenticated.', ['error' => 'Unauthenticated.']);
        }
    }
}
