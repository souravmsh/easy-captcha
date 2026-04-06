<?php

namespace Souravmsh\EasyCaptcha\Http\Controllers;

use Illuminate\Routing\Controller;
use Souravmsh\EasyCaptcha\Facades\EasyCaptcha;

class CaptchaController extends Controller
{
    /**
     * Generate the CAPTCHA image response.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate()
    {
        return EasyCaptcha::generate();
    }
}
