<?php
// Inspect MySQL DB using .env config: list tables, columns, and row counts.

$envPath = __DIR__ . '/../.env';
$env = [];
if (file_exists($envPath)) {
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $v = trim($v, "\"'" );
        $env[$k] = $v;
    }
}

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$user = $env['DB_USERNAME'] ?? 'root';
$pass = $env['DB_PASSWORD'] ?? '';
$db   = $env['DB_DATABASE'] ?? 'haustap';

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $db);
$out = [ 'driver' => 'mysql', 'host' => $host, 'port' => $port, 'database' => $db, 'tables' => [] ];

try {
    $pdo = new PDO($dsn, $user, $pass, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $t) {
        $colsStmt = $pdo->query('SHOW COLUMNS FROM `' . str_replace('`','``',$t) . '`');
        $cols = array_map(fn($row) => $row['Field'], $colsStmt->fetchAll(PDO::FETCH_ASSOC));
        $countStmt = $pdo->query('SELECT COUNT(*) AS c FROM `' . str_replace('`','``',$t) . '`');
        $count = (int)$countStmt->fetch(PDO::FETCH_ASSOC)['c'];
        $out['tables'][] = [ 'name' => $t, 'columns' => $cols, 'rows' => $count ];
    }
    $out['ok'] = true;
} catch (Throwable $e) {
    $out['ok'] = false;
    $out['error'] = $e->getMessage();
}

echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";