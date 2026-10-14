<?php
return [
    'disable' => env('CAPTCHA_DISABLE', false),
    'characters' => ['2', '3', '4', '6', '7', '8', '9'],
    'default' => [
        'length' => 4,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => false,
        'expire' => 60,
        'encrypt' => false,
        'fontColors' => ['#000000'], // Added this line
    ],
    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
        'fontColors' => ['#000000'], // Added this line
    ],
    'flat' => [
        'length' => 6,
        'width' => 160,
        'height' => 46,
        'quality' => 90,
        'lines' => 6,
        'bgImage' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#000000'], // Modified this line
        'contrast' => -5,
    ],
    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
        'fontColors' => ['#000000'], // Added this line
    ],
    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
        'fontColors' => ['#000000'], // Added this line
    ]
];
