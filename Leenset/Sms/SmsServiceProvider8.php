<?php

namespace Leenset\Sms;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider8 extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        //php artisan vendor:publish --provider=Leenset\Sms\SmsServiceProvider --tag=config
        $this->publishes([
            __DIR__ . './config/sms.php' => config_path('sms.php'),
        ]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('sms', function () {
			return new SmsResolver();
		});
		$this->mergeConfigFrom(
			__DIR__.'/config/sms.php', 'sms'
		);

	}
}
