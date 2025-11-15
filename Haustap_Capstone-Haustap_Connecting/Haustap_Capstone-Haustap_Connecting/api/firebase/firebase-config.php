<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Firebase configuration
$firebaseConfig = [
    'apiKey' => 'AIzaSyB2hI5X5_u8fRPVEE1z5N9nX3m9z5N9nX3',
    'authDomain' => 'haustap-project.firebaseapp.com',
    'projectId' => 'haustap-project',
    'storageBucket' => 'haustap-project.appspot.com',
    'messagingSenderId' => '123456789012',
    'appId' => '1:123456789012:web:abcdef1234567890abcdef'
];

echo json_encode([
    'success' => true,
    'config' => $firebaseConfig
]);
?>