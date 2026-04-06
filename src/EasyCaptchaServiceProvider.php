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
            __DIR__.'/../config/easy-captcha.php' => config_path('easy-captcha.php'),
        ], 'easy-captcha-config');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Blade::directive('easyCaptcha', function ($expression) {
            $expression = $expression ?: '[]';
            return "<?php echo \Souravmsh\EasyCaptcha\Facades\EasyCaptcha::img($expression); ?>";
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/easy-captcha.php', 'easy-captcha'
        );

        $this->app->singleton('easy-captcha', function ($app) {
            return new \Souravmsh\EasyCaptcha\Services\CaptchaService($app['config']);
        });
    }
}
