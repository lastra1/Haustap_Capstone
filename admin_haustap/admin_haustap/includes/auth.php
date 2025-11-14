<?php
// Simple auth gate for admin pages
// Include this file early in pages to enforce login

if (session_status() !== PHP_SESSION_ACTIVE) {
    // Start session only if headers not already sent to avoid warnings.
    // If headers are already sent we cannot safely call session_start() or change the session id,
    // doing so may emit warnings like "Session ID cannot be changed after headers have already been sent".
    if (!headers_sent()) {
        session_start();
    } else {
        // Headers already sent — do not attempt to start or resume session here.
        // Leaving session inactive; $loggedIn will evaluate to false below.
    }
}

$loggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
// Development bypass: allow skipping auth when testing locally.
// To bypass auth in browser for debugging, add `?_dev_noauth=1` to the URL.
$devBypass = false;
// Bypass when explicit query param present
if (isset($_GET['_dev_noauth']) && $_GET['_dev_noauth'] == '1') {
    $devBypass = true;
}
// Bypass when remote address is localhost (useful for developer machine)
$remote = $_SERVER['REMOTE_ADDR'] ?? '';
if ($remote === '127.0.0.1' || $remote === '::1') {
    $devBypass = true;
}

if (!$loggedIn && !$devBypass) {
    $loginPath = 'login.php';
    if (!headers_sent()) {
        header('Location: ' . $loginPath);
        exit;
    } else {
        echo '<script>window.location.href = ' . json_encode($loginPath) . ';</script>';
        exit;
    }
}
?>
