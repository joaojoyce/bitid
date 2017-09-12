<?php

return [
    'url' => [
        'scheme' => env('BITID_SCHEME','bitid://'),
        'callback' => env('BITID_CALLBACK','authenticate'),
        'url' => env('BITID_URL','localhost')
    ],
    'qr' => [
        'cache_folder' => env('BITID_QR_CACHE', 'bitid_qr')
    ]
];
