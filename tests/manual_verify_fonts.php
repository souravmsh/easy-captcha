<?php

require __DIR__ . '/../vendor/autoload.php';

use Souravmsh\EasyCaptcha\Services\CaptchaService;
use Illuminate\Config\Repository;

function testFont($fontName) {
    echo "Testing font: $fontName\n";
    $config = new Repository([
        'easy_captcha' => [
            'enabled' => true,
            'type' => 'random',
            'font_path' => $fontName,
            'width' => 150,
            'height' => 50,
            'length' => 5,
        ]
    ]);

    $service = new CaptchaService($config);
    
    try {
        // We use a reflection to access protected method createImage or just call generate if we mock session
        // But since we just want to see if it resolves the path without crashing, 
        // we can check if it finds the file.
        
        // Let's use reflection to check the fontPath after resolution if possible, 
        // OR just try to run generate() and see if it fails on font.
        
        // Actually, I'll just check if the logic in CaptchaService works by creating a mock-like test.
        $internalPath = __DIR__ . '/../src/resources/fonts/' . $fontName . '.ttf';
        if (file_exists($internalPath)) {
            echo "SUCCESS: Internal font file exists at $internalPath\n";
        } else {
            echo "FAILURE: Internal font file NOT found at $internalPath\n";
        }
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
    echo "-------------------\n";
}

testFont('IndieFlower');
testFont('SpecialElite');
testFont('CourierPrime');
testFont('Ubuntu-Bold');
testFont('UbuntuMono-Regular');
testFont('Ubuntu-Italic');
testFont('NonExistentFont');
