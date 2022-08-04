<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Interfaces\UserInterface;

class RegisterController extends Controller
{
    private UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    //
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
        $user = $this->userInterface->createUser($input);
        $token =  $user->createToken('MyApp')->plainTextToken;
        $update_token = $this->userInterface->updateUser($token, $request->name);
        $success['name'] =  $user->name;
        $success['token'] =  $token;

        if ($update_token) {
            return response()->json([
                'success' => 200,
                'message' => 'User created successfully.',
                'data' => $success,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Bad request !',
                'data' => $update_token,
            ]);
        }
   
        // return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 

            $success['name'] =  $user->name;
            $success['token'] =  $user->remember_token;
            
            if ($user) {
                return response()->json([
                    'success' => 200,
                    'message' => 'User login successfully.',
                    'data' => $success,
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad request !',
                    'data' => $user,
                ]);
            }
        }else{
            return response()->json([
                'code' => 000,
                'message' => 'Unauthorised',
            ]);
        }
    } 
}