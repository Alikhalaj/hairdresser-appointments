<?php

declare(strict_types=1);

namespace App\Helpers;

use SanjabVerify\Contracts\VerifyMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Leenset\Sms\Sms;

class SmsVerifyMethod implements VerifyMethod
{

    public function send(string $receiver, string $code)
    {
        $request = new Request;
        date_default_timezone_set("Asia/Tehran");
        // echo implode($MobileNumber); 
        // $sms = Sms::make();
        // $verificationCode = $sms->send($code, $receiver);
        return $code;
    }
}
