<?php
// Usage: php scripts/create_admin_cli.php "Admin Name" "admin@example.com" "password"
// Creates or updates an admin user and ensures the admin role is set.

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

function exit_with($code, $data) {
    if (is_array($data)) {
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
    } else {
        echo (string)$data . PHP_EOL;
    }
    exit($code);
}

if ($argc < 4) {
    exit_with(1, [
        'ok' => false,
        'error' => 'Usage: php scripts/create_admin_cli.php "Name" "Email" "Password"',
    ]);
}

$name = trim($argv[1]);
$email = trim($argv[2]);
$password = (string)$argv[3];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit_with(1, [ 'ok' => false, 'error' => 'Invalid email address' ]);
}
if (strlen($password) < 6) {
    exit_with(1, [ 'ok' => false, 'error' => 'Password must be at least 6 characters' ]);
}

try {
    $created = upsert_admin_user($email, $password, $name !== '' ? $name : 'Admin');
    record_login_event((int)$created['id'], $email, true);
    exit_with(0, [
        'ok' => true,
        'user' => $created,
        'message' => 'Admin provisioned successfully',
    ]);
} catch (Throwable $e) {
    exit_with(1, [ 'ok' => false, 'error' => $e->getMessage() ]);
}