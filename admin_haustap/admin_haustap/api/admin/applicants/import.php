<?php
declare(strict_types=1);
// Seed the admin_applicants table from storage/data/applicants.json if empty
header('Content-Type: application/json');

require_once __DIR__ . '/../../_lib/db.php';

try {
    $pdo = db_connect();
    ensure_applicants_schema($pdo);

    // Check if table already has data
    $has = (int) $pdo->query('SELECT COUNT(*) FROM admin_applicants')->fetchColumn();
    if ($has > 0) {
        echo json_encode(['success' => true, 'imported' => 0, 'message' => 'table_not_empty']);
        exit;
    }

    $dataPath = realpath(__DIR__ . '/../../../../../storage/data/applicants.json');
    if (!$dataPath || !is_file($dataPath)) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'json_not_found']);
        exit;
    }

    $raw = file_get_contents($dataPath);
    $items = json_decode($raw, true);
    if (!is_array($items)) { $items = []; }

    $ins = $pdo->prepare('INSERT INTO admin_applicants (name, email, phone, applied_at, status) VALUES (:name, :email, :phone, :applied_at, :status)');
    $count = 0;
    foreach ($items as $it) {
        $ins->execute([
            ':name' => $it['name'] ?? '',
            ':email' => $it['email'] ?? null,
            ':phone' => $it['phone'] ?? null,
            ':applied_at' => $it['applied_at'] ?? null,
            ':status' => $it['status'] ?? 'pending_review',
        ]);
        $count++;
    }

    echo json_encode(['success' => true, 'imported' => $count]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'server_error', 'message' => $e->getMessage()]);
}