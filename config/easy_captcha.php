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

    // Supported types: 'random', 'math', 'alphabet', 'number', 'google', 'turnstile'
    'type' => env('EASY_CAPTCHA_TYPE', 'random'),

    'google_site_key' => env('EASY_CAPTCHA_GOOGLE_SITE_KEY', ''),

    'google_secret_key' => env('EASY_CAPTCHA_GOOGLE_SECRET_KEY', ''),

    'google_api_version' => env('EASY_CAPTCHA_GOOGLE_API_VERSION', 'v3'), // v2 or v3 - if not set then default v3

    'google_score_threshold' => env('EASY_CAPTCHA_GOOGLE_SCORE_THRESHOLD', 0.5), // Score threshold for v3

    'turnstile_site_key' => env('EASY_CAPTCHA_TURNSTILE_SITE_KEY', ''),

    'turnstile_secret_key' => env('EASY_CAPTCHA_TURNSTILE_SECRET_KEY', ''),

    'characters' => env('EASY_CAPTCHA_CHARACTERS', '23456789abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ'),

    'length' => env('EASY_CAPTCHA_LENGTH', 5),

    'width' => env('EASY_CAPTCHA_WIDTH', 250),

    'height' => env('EASY_CAPTCHA_HEIGHT', 50),

    'bg_color' => env('EASY_CAPTCHA_BG_COLOR', '#bdbcbcff'), // Hex format: White

    'text_color' => env('EASY_CAPTCHA_TEXT_COLOR', '#0b7057ff'), // Hex format: Dark Gray

    'line_color' => env('EASY_CAPTCHA_LINE_COLOR', '#542e4cff'), // Hex format: Light Gray

    'font_size' => env('EASY_CAPTCHA_FONT_SIZE', 20),

    'font_weight' => env('EASY_CAPTCHA_FONT_WEIGHT', 2), // Font weight for the CAPTCHA text (1 = normal, >1 = bolder) - range 1 to 5

    // Supported fonts: 'IndieFlower', 'SpecialElite', 'CourierPrime', 'Ubuntu-Bold', 'UbuntuMono-Regular', 'Ubuntu-Italic'
    // Or provide absolute path to custom .ttf file
    'font_path' => env('EASY_CAPTCHA_FONT_PATH', 'UbuntuMono-Regular'),

    'lines' => env('EASY_CAPTCHA_LINES', 3), // Number of background noise lines

    'dots' => env('EASY_CAPTCHA_DOTS', 50), // Number of background noise dots

    'storage_limit' => env('EASY_CAPTCHA_STORAGE_LIMIT', 1000), // Max number of images to keep globally

    'expiry_minutes' => env('EASY_CAPTCHA_EXPIRY_MINUTES', 60), // Delete images older than this
];
