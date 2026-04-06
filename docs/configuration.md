# Configuration

Customize Easy Captcha to fit your application's needs.

## Configuration File

After publishing the config file, you will find it at `config/easy_captcha.php`.

```php
return [
    'enabled' => env('EASY_CAPTCHA_ENABLED', true),
    'type' => env('EASY_CAPTCHA_TYPE', 'math'), // options: random, math, alphabet, number, google
    // ... other settings
];
```

## Environment Variables

You can easily toggle CAPTCHA or change its type using your `.env` file:

```env
EASY_CAPTCHA_ENABLED=true
EASY_CAPTCHA_TYPE=math
```

### Supported Types

- **random**: Alphanumeric characters.
- **math**: Simple mathematical expressions (e.g., 5 + 3).
- **alphabet**: Letters only.
- **number**: Digits only.
- **google**: Integration with Google reCAPTCHA v2/v3.

## Google reCAPTCHA Setup

To use Google reCAPTCHA, set the type to `google` and provide your site and secret keys in the `.env` file:

```env
EASY_CAPTCHA_TYPE=google
EASY_CAPTCHA_GOOGLE_SITE_KEY=your-site-key-here
EASY_CAPTCHA_GOOGLE_SECRET_KEY=your-secret-key-here
```

Next, learn how to [use](./usage.md) Easy Captcha in your forms.
