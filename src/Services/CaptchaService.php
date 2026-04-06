<?php

namespace Souravmsh\EasyCaptcha\Services;

use Exception;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\Session;

class CaptchaService
{
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config->get('easy_captcha');
    }

    /**
     * Generate the CAPTCHA image and store the actual string in the session.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate()
    {
        if (isset($this->config['enabled']) && !$this->config['enabled']) {
            abort(404, 'CAPTCHA is disabled.');
        }

        $type = $this->config['type'] ?? 'random';
        
        if ($type === 'google') {
            abort(404, 'Google reCAPTCHA does not utilize local generation endpoints.');
        }
        
        $content = $this->generateContent($type, $this->config['length']);
        
        Session::put('easy_captcha', strtolower($content['answer']));

        return $this->createImage($content['display']);
    }

    /**
     * Determine if the provided CAPTCHA matches the generated one.
     *
     * @param string $val
     * @return bool
     */
    public function validate($val)
    {
        if (isset($this->config['enabled']) && !$this->config['enabled']) {
            return true;
        }

        $type = $this->config['type'] ?? 'random';

        if ($type === 'google') {
            return $this->verifyGoogleRecaptcha($val);
        }

        if (!Session::has('easy_captcha')) {
            return false;
        }

        $isValid = strtolower($val) === Session::get('easy_captcha');
        
        // Remove the session key after validation to prevent replay
        Session::forget('easy_captcha');

        // Cleanup the stored image file to prevent storage bloat
        if (Session::has('easy_captcha_path')) {
            $path = Session::get('easy_captcha_path');
            if (file_exists($path)) {
                @unlink($path);
            }
            Session::forget('easy_captcha_path');
        }

        return $isValid;
    }

    /**
     * Verifies against Google Recaptcha v2/v3 endpoint
     */
    protected function verifyGoogleRecaptcha($responseVal)
    {
        $secret = $this->config['google_secret_key'] ?? '';
        if (empty($secret)) {
            throw new \Exception('Easy Captcha: Google Secret Key (EASY_CAPTCHA_GOOGLE_SECRET_KEY) must be set in the configuration when type is google.');
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret,
            'response' => $responseVal
        ];
        
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $context  = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        
        if ($result === false) {
            return false;
        }
        
        $response = json_decode($result, true);
        return $response['success'] ?? false;
    }

    /**
     * Return html image tag.
     * 
     * @param array $attributes html attributes
     * @return string
     */
    public function img(array $attributes = [])
    {
        if (isset($this->config['enabled']) && !$this->config['enabled']) {
            return '';
        }

        $type = $this->config['type'] ?? 'random';
        if ($type === 'google') {
            $siteKey = $this->config['google_site_key'] ?? '';
            if (empty($siteKey)) {
                throw new \Exception('Easy Captcha: Google Site Key (EASY_CAPTCHA_GOOGLE_SITE_KEY) must be set in the configuration when type is google.');
            }
            return '<div class="g-recaptcha" data-sitekey="' . htmlspecialchars($siteKey) . '"></div><script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        }

        $url = route('easy-captcha.generate');
        $attrStr = '';
        foreach ($attributes as $key => $value) {
            if ($key !== 'id') {
                $attrStr .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
            }
        }
        $id = $attributes['id'] ?? 'easy-captcha-image-' . rand(1000, 9999);
        $attrStr .= ' id="' . $id . '"';

        return '<div class="easy-captcha-wrapper" style="position: relative; display: inline-block;">
            <img src="' . $url . '" alt="CAPTCHA" ' . $attrStr . ' style="display: block;">
            <button type="button" onclick="document.getElementById(\'' . $id . '\').src = \'' . $url . '?\' + Math.random()" 
                class="easy-captcha-reload-btn" 
                style="position: absolute; top: 5px; right: 5px; cursor: pointer; background: rgba(255, 255, 255, 0.8); border: none; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); color: #333; font-size: 18px; transition: all 0.3s ease; backdrop-filter: blur(4px); z-index: 10;" 
                onmouseover="this.style.background=\'#fff\'; this.style.transform=\'rotate(180deg)\'; this.style.color=\'#007bff\';" 
                onmouseout="this.style.background=\'rgba(255, 255, 255, 0.8)\'; this.style.transform=\'rotate(0deg)\'; this.style.color=\'#333\';"
                title="Reload CAPTCHA">&#x21bb;</button>
        </div>';
    }

    /**
     * Generate content for CAPTCHA based on type.
     */
    protected function generateContent($type, $length)
    {
        switch ($type) {
            case 'math':
                $n1 = rand(1, 9);
                $n2 = rand(1, 9);
                $operators = ['+', '-'];
                $operator = $operators[rand(0, 1)];
                
                $display = "$n1 $operator $n2";
                $answer = $operator === '+' ? ($n1 + $n2) : ($n1 - $n2);
                
                return ['display' => $display, 'answer' => (string)$answer];
                
            case 'alphabet':
                $characters = 'abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
                return $this->generateStringContent($characters, $length);
                
            case 'number':
                $characters = '123456789';
                return $this->generateStringContent($characters, $length);
                
            case 'random':
            default:
                $characters = $this->config['characters'] ?? '23456789abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
                return $this->generateStringContent($characters, $length);
        }
    }

    protected function generateStringContent($characters, $length)
    {
        $randomString = '';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return ['display' => $randomString, 'answer' => $randomString];
    }

    /**
     * Core GD function to generate pure image.
     */
    protected function createImage($text)
    {
        $width = $this->config['width'] ?? 150;
        $height = $this->config['height'] ?? 50;

        $image = imagecreatetruecolor($width, $height);

        // Colors
        $bgColorRGB = $this->config['bg_color'] ?? [255, 255, 255];
        $textColorRGB = $this->config['text_color'] ?? [50, 50, 50];
        $lineColorRGB = $this->config['line_color'] ?? [200, 200, 200];

        $bgColor = imagecolorallocate($image, $bgColorRGB[0], $bgColorRGB[1], $bgColorRGB[2]);
        $textColor = imagecolorallocate($image, $textColorRGB[0], $textColorRGB[1], $textColorRGB[2]);
        $lineColor = imagecolorallocate($image, $lineColorRGB[0], $lineColorRGB[1], $lineColorRGB[2]);

        imagefill($image, 0, 0, $bgColor);

        // Generate lines
        $lines = $this->config['lines'] ?? 5;
        for ($i = 0; $i < $lines; $i++) {
            imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
        }

        // Generate dots
        $dots = $this->config['dots'] ?? 100;
        for ($i = 0; $i < $dots; $i++) {
            imagesetpixel($image, rand(0, $width), rand(0, $height), $lineColor);
        }

        // Add text
        $fontSize = $this->config['font_size'] ?? 20;
        $fontPath = $this->config['font_path'] ?? null;
        
        if ($fontPath && function_exists('imagettftext')) {
            $x = ($width - ($fontSize * strlen($text))) / 2;
            $y = ($height + $fontSize) / 2;
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $text);
        } else {
            // Fallback for built-in GD font
            $fontWidth = imagefontwidth(5);
            $fontHeight = imagefontheight(5);
            $length = strlen($text);
            $textWidth = $length * $fontWidth;
            $x = ($width - $textWidth) / 2;
            $y = ($height - $fontHeight) / 2;
            
            // Basic random spacing and angle if we had ttf, but with imagestring it's simple
            for ($i = 0; $i < $length; $i++) {
                $charX = $x + ($i * 15); // spaced out slightly
                $charY = $y + rand(-5, 5); // bouncing effect
                imagestring($image, 5, $charX, $charY, $text[$i], $textColor);
            }
        }

        $directory = storage_path('app/easy-captcha');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // 1. Per-User Deletion: Remove the previous image for this session if it exists
        if (Session::has('easy_captcha_path')) {
            $oldPath = Session::get('easy_captcha_path');
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        $filename = 'captcha_' . uniqid() . '.png';
        $path = $directory . '/' . $filename;

        imagepng($image, $path);
        imagedestroy($image);

        // Store the file path in session for later cleanup
        Session::put('easy_captcha_path', $path);

        // 2. Perform global cleanup (Expiry and FIFO limit)
        $this->cleanupStorage($directory);

        return response()->file($path, [
            'Content-type' => 'image/png',
            'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
            'Pragma' => 'no-cache'
        ]);
    }

    /**
     * Cleanup old CAPTCHA images based on expiry and global limit.
     */
    protected function cleanupStorage($directory)
    {
        if (!is_dir($directory)) {
            return;
        }

        $files = glob($directory . '/captcha_*.png');
        $expiryMinutes = $this->config['expiry_minutes'] ?? 60;
        $expireTime = time() - ($expiryMinutes * 60);

        // a. Delete expired images (> 1 hour old by default)
        foreach ($files as $file) {
            if (filemtime($file) < $expireTime) {
                @unlink($file);
            }
        }

        // b. Enforce global storage limit (FIFO)
        $files = glob($directory . '/captcha_*.png');
        $limit = $this->config['storage_limit'] ?? 10;

        if (count($files) > $limit) {
            // Sort by modification time (oldest first)
            usort($files, function ($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            // Delete oldest images until we reach the limit
            $toDelete = count($files) - $limit;
            for ($i = 0; $i < $toDelete; $i++) {
                @unlink($files[$i]);
            }
        }
    }
}
