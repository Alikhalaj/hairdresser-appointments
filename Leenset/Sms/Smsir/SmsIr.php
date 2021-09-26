<?php

namespace Leenset\Sms\Smsir;

use Illuminate\Support\Facades\Http;

class SmsIr
{
    public $config;
    public $APIKey;
    public $SecretKey;
    public $APIURL;
    function setConfig($config)
    {
        $this->config = $config;
        $this->APIKey = $this->config->get('sms.smsir.api-key');
        $this->SecretKey = $this->config->get('sms.smsir.secret-key');
        $this->APIURL = $this->config->get('sms.smsir.api-url');
    }
    public function verificationCode($Code, $MobileNumber)
    {
        $token = $this->getToken();
        if ($token != false) {
            $postData = array(
                'Code' => $Code,
                'MobileNumber' => $MobileNumber,
            );

            $url = $this->APIURL . $this->getAPIVerificationCodeUrl();
            $VerificationCode = $this->execute($postData, $url, $token);
            $object = json_decode($VerificationCode);
            if (is_object($object)) {
                $result = $object->Message;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }
    public function execute($postData, $url, $token)
    {
        $result = Http::withHeaders([
            'Content-Type'=>'application/json',
            'x-sms-ir-secure-token' => $token
        ])->post($url, $postData);

        return $result;
    }
    public function send(string $message, string $mobilenumber)
    {
        echo "1";
        $token = $this->getToken();
        $postData = [
            "Messages" => [$message],
            "MobileNumbers" => [$mobilenumber],
            "LineNumber" => $this->config->get('sms.smsir.line-number'),
            "SendDateTime" => "",
            "CanContinueInCaseOfError" => "false",
        ];
        if ($token != false) {
            $url = $this->APIURL . $this->getAPIMessageSendUrl();
            echo "2";
            $message = $this->execute($postData, $url, $token);
            return $message;
            $object = json_decode($message);
            if (is_object($object)) {
                $result = $object->IsSuccessful;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }
    public function getToken()
    {
        $postData = array(
            'UserApiKey' => $this->config->get('sms.smsir.api-key'),
            'SecretKey' => $this->config->get('sms.smsir.secret-key'),
            'System' => 'php_rest_v_2_0'
        );
        $url =$this->APIURL . $this->getApiTokenUrl();
        $response = Http::contentType("application/json")->post($url, $postData);
        $response = json_decode($response);
        if (is_object($response)) {
            $IsSuccessful = $response->IsSuccessful;
            if ($IsSuccessful == true) {
                $TokenKey = $response->TokenKey;
                $resp = $TokenKey;
            } else {
                $resp = false;
            }
        }
        return $resp;
    }
    protected function getApiTokenUrl()
    {
        return "api/Token";
    }
    protected function getAPIVerificationCodeUrl()
    {
        return "api/VerificationCode";
    }
    protected function getAPIMessageSendUrl()
    {
        return "api/MessageSend";
    }
}
