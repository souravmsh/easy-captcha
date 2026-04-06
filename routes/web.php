<?php

use Illuminate\Support\Facades\Route;
use Souravmsh\EasyCaptcha\Http\Controllers\CaptchaController;

Route::group(['middleware' => ['web']], function () {
    Route::get('/easy-captcha/generate', [CaptchaController::class, 'generate'])->name('easy-captcha.generate');
});
