<?php

namespace App\Http\Controllers;

use App\Helpers\SmsVerifyMethod;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use App\Http\Requests\User\PhoneRequest;
use Illuminate\Http\Request;
use SanjabVerify\Support\Facades\Verify;

class UserController extends Controller
{
    public function loginRegister(Request $request)
    {
        $result = Verify::verify($request->input('phone'), $request->input('code'));
        if ($result['success'] == true) {
            if (User::where(['phone' => $request->input('phone')])->first() != null) {
                $result = Verify::verify($request->input('phone'), $request->input('code'));
                return $this->newSecssion($request);
            }
            $user = new User([
                'phone' => $request->input('phone')
            ]);
            $user->save();
            $user->assignRole('user');
            return $this->newSecssion($request, $user);
        } else {
            return "کد اشتباه وارد شده دوباره تلاش کنید";
        }
    }
    // user logout
    public function logout()
    {
        // 
    }
    //create session for user
    public function newSecssion($request, $user = null)
    {
        if ($user == null) {
            $user = User::where(['phone' => $request->input('phone')])->first();
            $user->update(['password' => bcrypt($request->input('code'))]);
            Auth::login($user, true);
            return $this->createTokenForNewSession($user);
        } else {
            // $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            Auth::login($user, true);
            return $this->createTokenForNewSession($user);
        }
    }
    //create Token for new session 
    private function createTokenForNewSession($user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    // update and complate profile
    private function update(Request $request)
    {
        // $User = auth()->user()->create($request);
    }

    public function send(Request $request)
    {
        $result = Verify::request($request->input('phone'), SmsVerifyMethod::class);
        return $result;
    }
}
