<?php

namespace Leenset\Sms;

use Illuminate\Support\Facades\Files;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Actual provider
     *
     * @var \Illuminate\Support\ServiceProvider
     */
    protected $provider;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->provider = $this->getProvider();
    }

    public function boot()
    {
        if (method_exists($this->provider, 'boot')) {
            return $this->provider->boot();
        }
    }
    private function getProvider()
    {
        $provider = 'Leenset\Sms\SmsServiceProvider8';

        return new $provider($this->app);
    }

    public function register()
	{
	    return $this->provider->register();
	}
}
