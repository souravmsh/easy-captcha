<?php

namespace Souravmsh\EasyCaptcha\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Souravmsh\EasyCaptcha\Facades\EasyCaptcha;

class Captcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!EasyCaptcha::validate($value)) {
            $fail('The :attribute is incorrect.');
        }
    }
}
