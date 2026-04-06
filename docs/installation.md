# Installation

Get started with Easy Captcha in your Laravel project.

## Requirements

- PHP 7.2.5+ or 8.0+
- Laravel 7, 8, 9, 10, 11, 12, or 13
- PHP GD Extension (`ext-gd`)

## Step 1: Install via Composer

Run the following command in your terminal:

```bash
composer require souravmsh/easy-captcha
```

## Step 2: Register Service Provider (Optional)

The package supports Laravel's package auto-discovery. However, if you have disabled it, you can register the service provider manually.

### For Laravel 11+
Add the service provider to `bootstrap/providers.php`:

```php
return [
    // ...
    Souravmsh\EasyCaptcha\EasyCaptchaServiceProvider::class,
];
```

### For Laravel 7 to 10
Add the service provider to the `providers` array in `config/app.php`:

```php
'providers' => [
    // ...
    Souravmsh\EasyCaptcha\EasyCaptchaServiceProvider::class,
],
```

## Step 3: Publish Configuration (Optional)

If you want to customize the CAPTCHA settings, publish the configuration file:

```bash
php artisan vendor:publish --tag=easy-captcha-config
```

Now you are ready to [configure](./configuration.md) your CAPTCHA!
