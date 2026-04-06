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

    'bg_color' => env('EASY_CAPTCHA_BG_COLOR', '#e5a8a8'), // Hex format: White
    
    'text_color' => env('EASY_CAPTCHA_TEXT_COLOR', '#0b3070'), // Hex format: Dark Gray
    
    'line_color' => env('EASY_CAPTCHA_LINE_COLOR', '#542e2eff'), // Hex format: Light Gray

    'font_size' => env('EASY_CAPTCHA_FONT_SIZE', 20),

    'font_weight' => env('EASY_CAPTCHA_FONT_WEIGHT', 2), // Font weight for the CAPTCHA text (1 = normal, >1 = bolder) - range 1 to 5

    'font_path' => env('EASY_CAPTCHA_FONT_PATH', null), // Provide absolute path to custom .ttf font file, otherwise default GD font is used
    
    'lines' => env('EASY_CAPTCHA_LINES', 4), // Number of background noise lines
    
    'dots' => env('EASY_CAPTCHA_DOTS', 80), // Number of background noise dots

    'storage_limit' => env('EASY_CAPTCHA_STORAGE_LIMIT', 1000), // Max number of images to keep globally

    'expiry_minutes' => env('EASY_CAPTCHA_EXPIRY_MINUTES', 60), // Delete images older than this
];
