<?php

function parseColor($color, $default = [0, 0, 0])
{
    if (is_array($color) && count($color) === 3) {
        return $color;
    }

    if (is_string($color)) {
        $color = trim($color);
        if (empty($color)) return $default;
        
        $color = ltrim($color, '#');
        
        if (strlen($color) === 3) {
            return [
                hexdec($color[0] . $color[0]),
                hexdec($color[1] . $color[1]),
                hexdec($color[2] . $color[2]),
            ];
        } elseif (strlen($color) === 6) {
            return [
                hexdec(substr($color, 0, 2)),
                hexdec(substr($color, 2, 2)),
                hexdec(substr($color, 4, 2)),
            ];
        }
    }

    return $default;
}

$cases = [
    '#ffffff',
    '#FFF',
    'ffffff',
    'FFF',
    '#ffffff ',
    ' #FFF',
    '',
    null,
    [255, 255, 255]
];

foreach ($cases as $case) {
    echo "Input: " . var_export($case, true) . " -> Output: " . var_export(parseColor($case, [255, 255, 255]), true) . "\n";
}
