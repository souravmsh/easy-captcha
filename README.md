# Easy Captcha

An easy, lightweight, pure image-based CAPTCHA package for Laravel (Requires ext-gd).
No third-party APIs needed. The CAPTCHA generates standard image data dynamically directly via PHP.
Also supports Google reCAPTCHA v2/v3.

## Installation

```bash
composer require souravmsh/easy-captcha
```

## Configuration

Optionally publish the configuration file to customize CAPTCHA sizes and colors:

```bash
php artisan vendor:publish --tag=easy-captcha-config
```

You can change the CAPTCHA type in `config/easy_captcha.php`, or easily turn the CAPTCHA off completely for local development/testing using your `.env` file:
```env
EASY_CAPTCHA_ENABLED=false
EASY_CAPTCHA_TYPE=math
```

Supported types: 
- `'random'` (Alphanumeric)
- `'math'` (e.g., 5 + 3, validation checks for 8)
- `'alphabet'` (Letters only)
- `'number'` (Numbers only)
- `'google'` (Google reCAPTCHA v2/v3 support!)

### Setting up Google reCAPTCHA 
If you choose `google` as the CAPTCHA type, our blade directive and validation facade will automatically hook into Google's APIs. Add your site/secret keys inside the `.env`:

```env
EASY_CAPTCHA_TYPE=google
EASY_CAPTCHA_GOOGLE_SITE_KEY=your-site-key-here
EASY_CAPTCHA_GOOGLE_SECRET_KEY=your-secret-key-here
```

## Usage

### Displaying the CAPTCHA image
In your Blade form, you can render an image tag manually:

```blade
@easyCaptcha
```

This simple blade directive handles showing the `<img />` and attaching a neat `[Reload]` button next to it!

Or you can use the Facade manually if you need more control:

```blade
{!! \Souravmsh\EasyCaptcha\Facades\EasyCaptcha::img(['class' => 'my-captcha-class']) !!}
```

### Validating the CAPTCHA

Once the form is submitted, validate the user's input:

```php
use Illuminate\Http\Request;

public function submit(Request $request) {
    $request->validate([
        'captcha' => 'required|captcha'
    ]);

    // Success! 
    return "Valid CAPTCHA!";
}
```

## Support

Laravel versions 7, 8, 9, 10, 11, 12, 13 are fully supported.
PHP 7.2.5+ & 8.0+ are required along with `ext-gd`.
