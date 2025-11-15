<?php
declare(strict_types=1);
header('Content-Type: application/json');

// DB-backed applicants endpoint with JSON fallback; preserves existing response shape
require_once __DIR__ . '/../../_lib/db.php';

try {
    $status = isset($_GET['status']) ? strtolower(trim($_GET['status'])) : 'all';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit  = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
    $offset = ($page - 1) * $limit;

    // Try DB first
    $pdo = db_connect();
    ensure_applicants_schema($pdo);

    $clauses = [];
    $params = [];
    if ($status !== 'all') {
        $clauses[] = 'LOWER(REPLACE(status, " ", "_")) = :status';
        $params[':status'] = $status;
    }
    if ($search !== '') {
        $clauses[] = '(LOWER(name) LIKE :q OR LOWER(email) LIKE :q OR LOWER(phone) LIKE :q)';
        $params[':q'] = '%' . strtolower($search) . '%';
    }
    $where = $clauses ? ('WHERE ' . implode(' AND ', $clauses)) : '';

    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM admin_applicants {$where}");
    foreach ($params as $k => $v) { $stmtCount->bindValue($k, $v); }
    $stmtCount->execute();
    $total = (int) $stmtCount->fetchColumn();

    $stmt = $pdo->prepare("SELECT id, name, email, phone, applied_at, status
                            FROM admin_applicants {$where}
                            ORDER BY id ASC
                            LIMIT :limit OFFSET :offset");
    foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
    $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'items' => $items,
        'page' => $page,
        'limit' => $limit,
        'total' => $total,
    ]);
    exit;
} catch (Throwable $e) {
    // Fallback: serve from JSON store if DB is unavailable
    try {
        $dataPath = realpath(__DIR__ . '/../../../../../storage/data/applicants.json');
        if (!$dataPath || !is_file($dataPath)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'server_error', 'message' => 'db_unavailable_and_json_missing']);
            exit;
        }
        $raw = file_get_contents($dataPath);
        $items = json_decode($raw, true);
        if (!is_array($items)) { $items = []; }

        $status = isset($_GET['status']) ? strtolower(trim($_GET['status'])) : 'all';
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;

        $filtered = array_values(array_filter($items, function($it) use ($status, $search) {
            $ok = true;
            if ($status !== 'all') {
                $st = strtolower(str_replace(' ', '_', $it['status'] ?? ''));
                $ok = $ok && ($st === $status);
            }
            if ($search !== '') {
                $hay = strtolower(($it['name'] ?? '') . ' ' . ($it['email'] ?? '') . ' ' . ($it['phone'] ?? ''));
                $ok = $ok && (strpos($hay, strtolower($search)) !== false);
            }
            return $ok;
        }));

        $total = count($filtered);
        $start = ($page - 1) * $limit;
        $paged = array_slice($filtered, $start, $limit);

        echo json_encode([
            'success' => true,
            'items' => $paged,
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
        ]);
        exit;
    } catch (Throwable $e2) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'server_error', 'message' => $e2->getMessage()]);
        exit;
    }
}