<?php

namespace App\Http\Controllers;

use App\Helpers\SmsVerifyMethod;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
// use App\Http\Requests\User\PhoneRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SanjabVerify\Support\Facades\Verify;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Resources\User as UserResources;

class UserController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return new UserResources($user);
    }

    public function loginRegister(Request $request)
    {
        $role = Role::where('name', 'barber')->first();
        if (!isset($role)) {
            Role::create(['name' => 'barber']);
        }
        $result = Verify::verify($request->input('phone'), $request->input('code'));
        if ($result['success'] == true) {
            if (User::where(['phone' => $request->input('phone')])->first() != null) {
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
    private function newSecssion($request, $user = null)
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
    public function edit(Request $request)
    {
        $user = Auth::user();
        $user->last_name = $request->input('last_name');
        $user->first_name = $request->input('first_name');
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'mimes:png|max:2048',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        if ($request->file('image')) {
            //store file into document folder
            $file = $request->file('image')->store('public/UserImage');
            // return $file;
            var_dump($request->all());
            //store your file into database
            $user->image = $file;
            $user->save();

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file
            ]);
        }
    }

    public function send(Request $request)
    {
        $result = Verify::request($request->input('phone'), SmsVerifyMethod::class);
        return $result;
    }
}
