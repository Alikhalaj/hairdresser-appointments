<?php

namespace App\Http\Controllers\Crm;

use App\Crm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class LoginController extends Controller
{
    public function authentication (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = Crm::where('email', $request->email)->first();
        if ($user) {
            // Auth::attempt($validator)Hash::check($request->password, $user->password)
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Crm')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function user(Request $request){
        $user = ['user_agent'=>$request->userAgent(),
            'user_ip'=>$request->ip(),
            'platform'=>$_SERVER['HTTP_USER_AGENT']];
            return $user;
    }
}
