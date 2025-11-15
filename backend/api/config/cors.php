<?php

return [
    'paths' => ['api/*', 'bookings*', 'chat*', 'auth*', 'admin*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        // Development origins
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
        
        // Production origins - Update these with your actual domains
        'https://*.onrender.com',        // Render deployed API
        'https://*.railway.app',         // Railway deployed API
        'https://*.vercel.app',          // Vercel deployed frontend
        'https://*.netlify.app',         // Netlify deployed frontend
        'capacitor://localhost',          // Capacitor/Cordova apps
        'http://localhost',               // Mobile app development
        
        // Dynamic production origins from environment
        env('CORS_ALLOWED_ORIGINS', 'https://haustap.com'),
    ],
    'allowed_origins_patterns' => [
        '/^http:\/\/localhost:\d+$/',
        '/^http:\/\/127\.0\.0\.1:\d+$/',
        // Allow any IPv4 host with any port (dev convenience)
        '/^http:\/\/\d{1,3}(?:\.\d{1,3}){3}:\d+$/',
    ],
    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'Accept',
        'Accept-Language',
        'Content-Language',
        'Cache-Control',
        'X-CSRF-TOKEN',
        'X-API-KEY',
        'X-Device-ID',
        'X-App-Version',
        'X-Platform',
        'X-Timezone'
    ],
    'exposed_headers' => [
        'X-Total-Count',
        'X-Page-Count',
        'X-Per-Page',
        'X-Current-Page',
        'X-Next-Page',
        'X-Prev-Page'
    ],
    'max_age' => 86400, // 24 hours
    'supports_credentials' => true,
];