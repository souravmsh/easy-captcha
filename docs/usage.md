# Usage

Learn how to implement and validate Easy Captcha in your Laravel applications.

## Displaying the CAPTCHA

### Using Blade Directive

The easiest way to display the CAPTCHA is by using the `@easyCaptcha` blade directive in your form.

```blade
<form action="/submit" method="POST">
    @csrf
    <!-- Your form fields -->

    <div class="form-group">
        @easyCaptcha
    </div>

    <button type="submit">Submit</button>
</form>
```

This directive automatically renders the CAPTCHA image and a "Reload" button.

### Manual Rendering

If you need more control, you can use the `EasyCaptcha` facade:

```blade
{!! EasyCaptcha::img(['class' => 'custom-captcha', 'id' => 'my-captcha']) !!}
```

## Validating the CAPTCHA

In your controller, you can validate the CAPTCHA input using several methods.

### Using the `captcha` rule

```php
use Illuminate\Http\Request;

public function store(Request $request) {
    $request->validate([
        'captcha' => 'required|captcha',
    ]);

    // Proceed with form processing
}
```

### Using the Rule Class

```php
use Souravmsh\EasyCaptcha\Rules\Captcha;

$request->validate([
    'captcha' => ['required', new Captcha],
]);
```

### Using Aliases

You can also use `easy_captcha` or `easyCaptcha` aliases:

```php
$request->validate([
    'captcha' => 'required|easy_captcha',
]);
```

## Customizing the Output

You can pass an array of attributes to the `@easyCaptcha` directive to customize the image tag:

```blade
@easyCaptcha(['class' => 'my-custom-class', 'width' => 150])
```

Check the [Installation](./installation.md) or [Configuration](./configuration.md) pages for more details.
