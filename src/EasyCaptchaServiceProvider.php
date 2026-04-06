<?php

namespace Souravmsh\EasyCaptcha;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Factory as Validator;

class EasyCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/easy_captcha.php', 'easy_captcha'
        );

        $this->app->singleton('easy-captcha', function ($app) {
            return new \Souravmsh\EasyCaptcha\Services\CaptchaService($app['config']);
        });
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(Validator $validator)
    {
        $this->publishes([
            __DIR__.'/../config/easy_captcha.php' => config_path('easy_captcha.php'),
        ], 'easy-captcha-config');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Blade::directive('easyCaptcha', function ($expression) {
            $expression = $expression ?: '[]';
            return "<?php echo \Souravmsh\EasyCaptcha\Facades\EasyCaptcha::img($expression); ?>";
        });

        // Register validation rules: 'captcha' and 'easy_captcha'
        $validator->extend('captcha', function ($attribute, $value) {
            return $this->app['easy-captcha']->validate($value);
        }, 'The :attribute is incorrect.');

        $validator->extend('easy_captcha', function ($attribute, $value) {
            return $this->app['easy-captcha']->validate($value);
        }, 'The :attribute is incorrect.');
    }
}
