<?php
namespace App\Controllers\Admin;

final class ClientsController {
    private static function normalizeStatus(?string $s): string {
        $s = strtolower(trim((string)($s ?? '')));
        if ($s === '') { return 'active'; }
        if ($s === 'suspend') { return 'suspended'; }
        return $s;
    }

    private function json(array $payload, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    // GET /api/admin/clients?status=all&search=&page=1&limit=10
    public function index(): void {
        $status = isset($_GET['status']) ? strtolower(trim((string)$_GET['status'])) : 'all';
        $search = isset($_GET['search']) ? trim((string)$_GET['search']) : '';
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = isset($_GET['limit']) ? max(1, min(100, (int)$_GET['limit'])) : 10;
        $offset = ($page - 1) * $limit;

        try {
            require_once \BASE_PATH . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '_lib' . DIRECTORY_SEPARATOR . 'db.php';
            $pdo = \db_connect();

            // Check if users.role exists; else use user_roles
            $hasRole = false;
            try {
                $stmtRole = $pdo->prepare("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'role'");
                $stmtRole->execute();
                $hasRole = ((int)$stmtRole->fetchColumn() > 0);
            } catch (\Throwable $_) { $hasRole = false; }

            $clauses = [];
            $params = [];
            $base = $hasRole
                ? 'FROM users u WHERE u.role = :role'
                : 'FROM users u JOIN user_roles r ON r.user_id = u.id AND r.role = :role';
            $params[':role'] = 'client';
            if ($search !== '') {
                $clauses[] = '(u.name LIKE :q OR u.email LIKE :q)';
                $params[':q'] = '%' . $search . '%';
            }
            // Status filter placeholder; default all clients as active
            $where = $clauses ? (' AND ' . implode(' AND ', $clauses)) : '';

            $sqlCount = 'SELECT COUNT(*) AS c ' . $base . $where;
            $stmtCount = $pdo->prepare($sqlCount);
            foreach ($params as $k => $v) { $stmtCount->bindValue($k, $v); }
            $stmtCount->execute();
            $total = (int)($stmtCount->fetchColumn() ?: 0);

            $sql = 'SELECT u.id, u.name, u.email, u.created_at ' . $base . $where . ' ORDER BY u.created_at DESC LIMIT :limit OFFSET :offset';
            $stmt = $pdo->prepare($sql);
            foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
            foreach ($rows as &$row) {
                $row['status'] = 'active';
            }

            $this->json([
                'success' => true,
                'items'   => $rows,
                'page'    => $page,
                'limit'   => $limit,
                'total'   => $total,
            ]);
            return;
        } catch (\Throwable $e) {
            // Fallback: clients.json
            $storeFile = \BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'clients.json';
            $items = [];
            if (is_file($storeFile)) {
                $raw = @file_get_contents($storeFile);
                $data = json_decode($raw ?: '[]', true);
                if (is_array($data)) { $items = $data; }
            }
            $filtered = array_values(array_filter($items, function($it) use ($status, $search) {
                $itStatus = self::normalizeStatus($it['status'] ?? 'active');
                if ($status !== 'all' && $itStatus !== $status) { return false; }
                if ($search !== '') {
                    $hay = strtolower(($it['name'] ?? '') . ' ' . ($it['email'] ?? '') . ' ' . ($it['phone'] ?? ''));
                    if (strpos($hay, strtolower($search)) === false) { return false; }
                }
                return true;
            }));
            $total  = count($filtered);
            $paged  = array_slice($filtered, $offset, $limit);
            $this->json([
                'success' => true,
                'items'   => $paged,
                'page'    => $page,
                'limit'   => $limit,
                'total'   => $total,
                'fallback' => 'json_store',
            ]);
        }
    }
}