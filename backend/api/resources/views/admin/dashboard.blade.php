<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HausTap Admin</title>
    <style>
        html, body { height: 100%; margin: 0; }
        .frame { height: 100vh; width: 100vw; border: 0; }
    </style>
</head>
<body>
    <iframe class="frame" src="{{ env('LEGACY_ADMIN_URL', 'http://localhost:5001/admin_haustap/admin_haustap/dashboard.php') }}" allow="clipboard-write; fullscreen" title="Admin"></iframe>
</body>
</html>