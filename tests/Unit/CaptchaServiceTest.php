<?php

namespace Souravmsh\EasyCaptcha\Tests\Unit;

use Souravmsh\EasyCaptcha\Tests\TestCase;
use Souravmsh\EasyCaptcha\Facades\EasyCaptcha;
use Illuminate\Support\Facades\Session;

class CaptchaServiceTest extends TestCase
{
    public function test_validate_returns_true_when_disabled()
    {
        config(['easy-captcha.enabled' => false]);
        
        $this->assertTrue(EasyCaptcha::validate('anything'));
    }
    
    public function test_validate_matches_session_value()
    {
        Session::put('easy_captcha', 'correctanswer');
        
        $this->assertTrue(EasyCaptcha::validate('correctanswer'));
        $this->assertFalse(Session::has('easy_captcha'), 'Session key should be forgotten after validation.');
    }
    
    public function test_validate_fails_on_incorrect_value()
    {
        Session::put('easy_captcha', 'correctanswer');
        
        $this->assertFalse(EasyCaptcha::validate('wronganswer'));
    }
    
    public function test_img_returns_empty_when_disabled()
    {
        config(['easy-captcha.enabled' => false]);
        
        $this->assertEquals('', EasyCaptcha::img());
    }
    
    public function test_img_generates_html_output()
    {
        $html = EasyCaptcha::img(['class' => 'my-captcha']);
        
        $this->assertStringContainsString('my-captcha', $html);
        $this->assertStringContainsString('img src="', $html);
        $this->assertStringContainsString('easy-captcha-reload-btn', $html);
        $this->assertStringContainsString('onclick=', $html);
    }
}
