<?php
// Lightweight MySQL connector for the Admin UI
// Reads DB config from backend/api/.env when available, with sensible local fallbacks.

function __read_env_file($path)
{
    $vars = [];
    if (!is_file($path)) return $vars;
    $lines = @file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!$lines) return $vars;
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        $pos = strpos($line, '=');
        if ($pos === false) continue;
        $key = trim(substr($line, 0, $pos));
        $val = trim(substr($line, $pos + 1));
        $val = preg_replace('/^"|"$/', '', $val);
        $val = preg_replace("/^'|'$/", '', $val);
        $vars[$key] = $val;
    }
    return $vars;
}

function __env($key, $default = null)
{
    static $ENV_CACHE = null;
    if ($ENV_CACHE === null) {
        // Try backend/api/.env relative to this file
        $base = dirname(__DIR__, 2); // Haustap_Updated
        $envPath = $base . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '.env';
        $ENV_CACHE = __read_env_file($envPath);
    }
    if (array_key_exists($key, $ENV_CACHE)) return $ENV_CACHE[$key];
    $sys = getenv($key);
    return $sys !== false ? $sys : $default;
}

function db_config()
{
    // Prefer values in backend/api/.env, else fall back to local dev defaults
    $driver = __env('DB_CONNECTION', 'mysql');
    $host = __env('DB_HOST', '127.0.0.1');
    $port = __env('DB_PORT', '3306');
    $name = __env('DB_DATABASE', 'haustap');
    $user = __env('DB_USERNAME', 'root');
    $pass = __env('DB_PASSWORD', 'root');
    return [
        'driver' => $driver,
        'host' => $host,
        'port' => (int)$port,
        'database' => $name,
        'username' => $user,
        'password' => $pass,
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ];
}

function get_db()
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $cfg = db_config();
    if ($cfg['driver'] !== 'mysql') {
        throw new RuntimeException('Admin DB driver must be mysql for this environment');
    }
    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $cfg['host'], $cfg['port'], $cfg['database'], $cfg['charset']);
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], $options);
        return $pdo;
    } catch (Throwable $e) {
        http_response_code(500);
        die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
    }
}

function table_exists(PDO $db, string $table): bool
{
    try {
        $stmt = $db->prepare('SELECT COUNT(*) AS c FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?');
        $stmt->execute([$table]);
        $row = $stmt->fetch();
        return ($row && (int)$row['c'] > 0);
    } catch (Throwable $e) {
        return false;
    }
}

function column_exists(PDO $db, string $table, string $column): bool
{
    try {
        $stmt = $db->prepare('SELECT COUNT(*) AS c FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?');
        $stmt->execute([$table, $column]);
        $row = $stmt->fetch();
        return ($row && (int)$row['c'] > 0);
    } catch (Throwable $e) {
        return false;
    }
}

?>