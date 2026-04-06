<?php

namespace Souravmsh\EasyCaptcha\Tests\Feature;

use Souravmsh\EasyCaptcha\Tests\TestCase;
use Illuminate\Support\Facades\Session;

class CaptchaTest extends TestCase
{
    public function test_generation_route_creates_image_and_stores_session()
    {
        $response = $this->get('/easy-captcha/generate');
        
        $response->assertStatus(200);
        $response->assertHeader('Content-type', 'image/png');
        
        $this->assertTrue(Session::has('easy_captcha'));
        $this->assertNotEmpty(Session::get('easy_captcha'));
    }
    
    public function test_generation_route_returns_404_when_disabled()
    {
        config(['easy-captcha.enabled' => false]);
        
        $response = $this->get('/easy-captcha/generate');
        
        $response->assertStatus(404);
        $this->assertFalse(Session::has('easy_captcha'));
    }
}
