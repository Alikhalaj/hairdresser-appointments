<?php

namespace App\Http\Controllers\Crm;

use App\Crm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Crm\RegisterRequest;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function authentication(RegisterRequest $request)
    {
        try {
            $request['password'] = Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);
            $user = Crm::create($request->toArray());
            $token = $user->createToken('Crm')->accessToken;
            $response = ['token' => $token];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return $e;
        }
    }
}
