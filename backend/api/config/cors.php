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
        'http://localhost:8082',
        'http://127.0.0.1:8082',
        // Allow Expo web served from the server IP during development
        'http://26.242.103.174:8082',
        'http://26.242.103.174:8081',
    ],
    'allowed_origins_patterns' => [
        '/^http:\/\/localhost:\d+$/',
        '/^http:\/\/127\.0\.0\.1:\d+$/',
        // Allow any IPv4 host with any port (dev convenience)
        '/^http:\/\/\d{1,3}(?:\.\d{1,3}){3}:\d+$/',
    ],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];