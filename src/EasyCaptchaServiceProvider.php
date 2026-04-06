<?php

namespace Souravmsh\EasyCaptcha;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class EasyCaptchaServiceProvider extends ServiceProvider
{
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
     */
    protected function registerValidationRules()
    {
        $validator = $this->app['validator'];
        $rules = ['captcha', 'easy_captcha', 'easyCaptcha'];
        foreach ($rules as $rule) {
            $validator->extend($rule, function ($attribute, $value) {
                return $this->app['easy-captcha']->validate($value);
            }, 'The :attribute is incorrect.');
        }
    }

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
}
