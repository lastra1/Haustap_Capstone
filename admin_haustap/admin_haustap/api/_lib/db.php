<?php
// Simple PDO database helper for admin API
// Loads environment via project bootstrap and provides schema helpers

declare(strict_types=1);

// Load project bootstrap to populate $_ENV and constants
require_once __DIR__ . '/../../../../bootstrap.php';

// Prefer reading DB settings from backend/api/.env to centralize with Laravel
function _read_env_file(string $path): array {
    $vars = [];
    if (!is_file($path)) return $vars;
    $lines = @file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!$lines) return $vars;
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
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

function db_connect(): PDO {
    // Load backend/api/.env if present
    $backendEnv = _read_env_file(BASE_PATH . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '.env');
    $env = function(string $key, ?string $default = null) use ($backendEnv) {
        if (array_key_exists($key, $backendEnv)) return $backendEnv[$key];
        $v = getenv($key);
        return ($v !== false && $v !== '') ? $v : ($default ?? '');
    };

    $driver = strtolower($env('DB_CONNECTION', 'sqlite'));

    if ($driver === 'sqlite') {
        $dbPath = $env('DB_DATABASE', BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'admin.sqlite');
        $dir = dirname($dbPath);
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
        $pdo = new PDO('sqlite:' . $dbPath);
    } else {
        $host = $env('DB_HOST', '127.0.0.1');
        $port = $env('DB_PORT', '3306');
        $db   = $env('DB_DATABASE', 'haustap');
        $user = $env('DB_USERNAME', 'root');
        $pass = $env('DB_PASSWORD', '');
        $charset = 'utf8mb4';
        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function ensure_applicants_schema(PDO $pdo): void {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $sql = "CREATE TABLE IF NOT EXISTS admin_applicants (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT,
            phone TEXT,
            applied_at TEXT,
            status TEXT
        )";
        $pdo->exec($sql);
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS admin_applicants (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255),
            phone VARCHAR(64),
            applied_at DATE NULL,
            status VARCHAR(64)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
    }
}

// Minimal users schema used by admin APIs (Providers/Bookings)
function ensure_users_schema(PDO $pdo): void {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT,
            email TEXT,
            role TEXT,
            created_at TEXT
        )";
        $pdo->exec($sql);
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            email VARCHAR(255),
            role VARCHAR(64),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
    }
}

// Fallback role mapping when users.role is absent in existing DBs
function ensure_user_roles_schema(PDO $pdo): void {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $sql = "CREATE TABLE IF NOT EXISTS user_roles (
            user_id INTEGER,
            role TEXT,
            PRIMARY KEY (user_id, role)
        )";
        $pdo->exec($sql);
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS user_roles (
            user_id INT,
            role VARCHAR(64),
            PRIMARY KEY (user_id, role)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
    }
}

// Provider profile tables (prefer service_providers; fallback providers)
function ensure_service_providers_schema(PDO $pdo): void {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $sql = "CREATE TABLE IF NOT EXISTS service_providers (
            user_id INTEGER UNIQUE,
            company_name TEXT,
            rating REAL
        )";
        $pdo->exec($sql);
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS service_providers (
            user_id INT UNIQUE,
            company_name VARCHAR(255),
            rating DECIMAL(3,2)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
    }
}

function ensure_providers_schema(PDO $pdo): void {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $sql = "CREATE TABLE IF NOT EXISTS providers (
            user_id INTEGER UNIQUE,
            rating REAL,
            status TEXT,
            service_categories TEXT
        )";
        $pdo->exec($sql);
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS providers (
            user_id INT UNIQUE,
            rating DECIMAL(3,2),
            status VARCHAR(64),
            service_categories JSON
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
    }
}

// Bookings used by admin list & counts
function ensure_bookings_schema(PDO $pdo): void {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $sql = "CREATE TABLE IF NOT EXISTS bookings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            client_id INTEGER,
            provider_id INTEGER,
            service_name TEXT,
            scheduled_date TEXT,
            scheduled_time TEXT,
            status TEXT
        )";
        $pdo->exec($sql);
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS bookings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            client_id INT,
            provider_id INT,
            service_name VARCHAR(255),
            scheduled_date DATE NULL,
            scheduled_time VARCHAR(16),
            status VARCHAR(64)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
    }
}

// Admin notifications (lightweight store for recent items shown in bell dropdown)
function ensure_notifications_schema(PDO $pdo): void {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $sql = "CREATE TABLE IF NOT EXISTS admin_notifications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            body TEXT,
            type TEXT,
            ts INTEGER,
            is_read INTEGER DEFAULT 0,
            link TEXT
        )";
        $pdo->exec($sql);
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS admin_notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            body TEXT NULL,
            type VARCHAR(64) NULL,
            ts BIGINT NULL,
            is_read TINYINT(1) NOT NULL DEFAULT 0,
            link VARCHAR(255) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
    }
}