<?php

namespace Souravmsh\EasyCaptcha\Tests\Unit;

use Souravmsh\EasyCaptcha\Tests\TestCase;
use Souravmsh\EasyCaptcha\Facades\EasyCaptcha;
use Illuminate\Support\Facades\Config;

class TurnstileTest extends TestCase
{
    public function test_img_returns_turnstile_html_when_type_is_turnstile()
    {
        config([
            'easy_captcha.type' => 'turnstile',
            'easy_captcha.turnstile_site_key' => 'test-site-key'
        ]);

        $html = EasyCaptcha::img();

        $this->assertStringContainsString('class="cf-turnstile"', $html);
        $this->assertStringContainsString('data-sitekey="test-site-key"', $html);
        $this->assertStringContainsString('https://challenges.cloudflare.com/turnstile/v0/api.js', $html);
    }

    public function test_img_throws_exception_if_turnstile_site_key_is_missing()
    {
        config([
            'easy_captcha.type' => 'turnstile',
            'easy_captcha.turnstile_site_key' => ''
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Easy Captcha: Cloudflare Turnstile Site Key (EASY_CAPTCHA_TURNSTILE_SITE_KEY) must be set in the configuration when type is turnstile.');

        EasyCaptcha::img();
    }

    public function test_validate_calls_verify_turnstile_when_type_is_turnstile()
    {
        // This is hard to test deeply without mocking file_get_contents or refactoring to use Http facade.
        // But we can at least check if it throws error if secret key is missing.
        
        config([
            'easy_captcha.type' => 'turnstile',
            'easy_captcha.turnstile_secret_key' => ''
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Easy Captcha: Cloudflare Turnstile Secret Key (EASY_CAPTCHA_TURNSTILE_SECRET_KEY) must be set in the configuration when type is turnstile.');

        EasyCaptcha::validate('test-response');
    }
}
