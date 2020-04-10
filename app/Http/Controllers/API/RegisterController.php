<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
   
        $response = [
            'success' => true,
            'data'    => $success,
            'message' => 'User register successfully.',
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('AdminLara')-> accessToken; 
            $success['user'] =  $user;
   
            $response = [
                'success' => true,
                'data'    => $success,
                'message' => 'User loggedin successfully.',
            ];

            return response()->json($response, 200);
        } 
        else{ 
            return response()->json(['error'=>'Invalid Credentials'], 404);
        } 
    }

    public function logout(Request $request) 
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        $response = [
            'success' => true,
            'data'    => array(),
            'message' => 'User logged out successfully.',
        ];
        return response()->json($response, 200);
    }
}
