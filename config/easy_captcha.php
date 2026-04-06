<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Easy Captcha Configuration
    |--------------------------------------------------------------------------
    |
    | Define the settings for generating the CAPTCHA image.
    |
    */

    'enabled' => env('EASY_CAPTCHA_ENABLED', true),
    
    // Supported types: 'random', 'math', 'alphabet', 'number', 'google'
    'type' => env('EASY_CAPTCHA_TYPE', 'random'),

    'google_site_key' => env('EASY_CAPTCHA_GOOGLE_SITE_KEY', ''),
    
    'google_secret_key' => env('EASY_CAPTCHA_GOOGLE_SECRET_KEY', ''),

    'characters' => env('EASY_CAPTCHA_CHARACTERS', '23456789abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ'),
    
    'length' => env('EASY_CAPTCHA_LENGTH', 5),

    'width' => env('EASY_CAPTCHA_WIDTH', 250),

    'height' => env('EASY_CAPTCHA_HEIGHT', 50),

    'bg_color' => [255, 255, 255], // RGB format: White

    'text_color' => [50, 50, 50], // RGB format: Dark Gray
    
    'line_color' => [200, 200, 200], // RGB format: Light Gray

    'font_size' => 20,

    'font_path' => null, // Provide absolute path to custom .ttf font file, otherwise default GD font is used
    
    'lines' => 5, // Number of background noise lines
    
    'dots' => 100, // Number of background noise dots
];
