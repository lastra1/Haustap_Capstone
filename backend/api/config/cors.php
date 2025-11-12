<?php

return [
    'paths' => ['api/*', 'bookings*', 'chat*', 'auth*', 'admin*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:5000',
        'http://127.0.0.1:5000',
        'http://localhost:5001',
        'http://127.0.0.1:5001',
        'http://localhost:8081',
        'http://127.0.0.1:8081',
    ],
    'allowed_origins_patterns' => [
        '/^http:\/\/localhost:\d+$/',
        '/^http:\/\/127\.0\.0\.1:\d+$/',
    ],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];