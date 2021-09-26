<?php

namespace Leenset\Sms;

use Leenset\Sms\Smsir\SmsIr;
use Leenset\Sms\Rayansms\RayanSms;
use Leenset\Sms\Exceptions\PortNotFoundException;

class SmsResolver
{
    public $config;

    public $driver;

    private $classes = [
        'smsir' => '\Smsir\SmsIr',
        'rayansms' => '\Rayansms\RayanSms',
    ];
    public function __construct($config = null, $driver = null)
    {
        $this->config = app('config');
        if (!is_null($driver)) $this->make($driver);
    }

    public function make($driver = 'smsir')
    {
        foreach ($this->classes as $key => $class) {
            $class = __NAMESPACE__ .$class ;
            if ($this->check($driver = $key)) {
                $driver = new $class;
                $this->driver = $driver;
            }
        }    
        $this->driver->setConfig($this->config); // injects config
        return $this;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->driver, $name], $arguments);
    }

    private function check(string $driver)
    {
        if ($this->config->get('sms.default') == $driver) {
            if (strlen($this->config->get('sms.default')) != 0) {
                return true;
            }
        }
    }
}
