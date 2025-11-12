<?php
header('Content-Type: application/json');

require_once dirname(__DIR__) . '/includes/db.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        exit;
    }
    $name = trim((string)($_POST['system_name'] ?? ''));
    $email = trim((string)($_POST['contact_email'] ?? ''));
    if ($name === '' || $email === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Missing fields']);
        exit;
    }

    $db = get_db();
    if (!table_exists($db, 'system_settings')) {
        // Create table on-the-fly if migrations did not run yet (safety for dev)
        $db->exec("CREATE TABLE IF NOT EXISTS system_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            system_name VARCHAR(255) NOT NULL DEFAULT 'HausTap',
            contact_email VARCHAR(255) NOT NULL DEFAULT 'support@example.com',
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )");
    }

    $row = $db->query('SELECT id FROM system_settings ORDER BY id ASC LIMIT 1')->fetch();
    $now = date('Y-m-d H:i:s');
    if ($row && isset($row['id'])) {
        $stmt = $db->prepare('UPDATE system_settings SET system_name = ?, contact_email = ?, updated_at = ? WHERE id = ?');
        $stmt->execute([$name, $email, $now, (int)$row['id']]);
    } else {
        $stmt = $db->prepare('INSERT INTO system_settings (system_name, contact_email, created_at, updated_at) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $now, $now]);
    }

    echo json_encode(['ok' => true]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

?>

