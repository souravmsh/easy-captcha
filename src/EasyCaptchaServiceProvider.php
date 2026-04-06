<?php

namespace Souravmsh\EasyCaptcha;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\Validation\Factory;

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
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/easy_captcha.php' => config_path('easy_captcha.php'),
        ], 'easy-captcha-config');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Blade::directive('easyCaptcha', function ($expression) {
            $expression = $expression ?: '[]';
            return "<?php echo \Souravmsh\EasyCaptcha\Facades\EasyCaptcha::img($expression); ?>";
        });

        $this->registerValidationRules();
    }

    /**
     * Register the custom validation rules.
     * Uses callAfterResolving to ensure the validator factory is ready.
     */
    protected function registerValidationRules()
    {
        $this->callAfterResolving(Factory::class, function (Factory $validator) {
            $callback = function ($attribute, $value) {
                return $this->app['easy-captcha']->validate($value);
            };

            $validator->extend('captcha', $callback, 'The :attribute is incorrect.');
            $validator->extend('easy_captcha', $callback, 'The :attribute is incorrect.');
            $validator->extend('easyCaptcha', $callback, 'The :attribute is incorrect.');
        });
    }
}
