<?php

namespace Souravmsh\EasyCaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class EasyCaptcha extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'easy-captcha';
    }
}
