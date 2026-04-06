<?php

namespace Souravmsh\EasyCaptcha\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Souravmsh\EasyCaptcha\EasyCaptchaServiceProvider;
use Souravmsh\EasyCaptcha\Facades\EasyCaptcha;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            EasyCaptchaServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'EasyCaptcha' => EasyCaptcha::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('easy-captcha', [
            'enabled' => true,
            'type' => 'math',
            'characters' => '23456789',
            'length' => 5,
            'width' => 120,
            'height' => 36,
            'bg_color' => [255, 255, 255],
            'text_color' => [0, 0, 0],
            'line_color' => [200, 200, 200],
            'lines' => 3,
            'dots' => 10,
        ]);
    }
}
