<?php
namespace App\Controllers\Admin;

final class ProvidersController {
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

    // GET /api/admin/providers?status=all&search=&page=1&limit=10
    public function index(): void {
        $status = isset($_GET['status']) ? strtolower(trim((string)$_GET['status'])) : 'all';
        $search = isset($_GET['search']) ? trim((string)$_GET['search']) : '';
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = isset($_GET['limit']) ? max(1, min(100, (int)$_GET['limit'])) : 10;
        $offset = ($page - 1) * $limit;

        try {
            require_once \BASE_PATH . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '_lib' . DIRECTORY_SEPARATOR . 'db.php';
            $pdo = \db_connect();

            // Ensure minimal schemas exist so DB queries succeed even on fresh databases
            try {
                \ensure_users_schema($pdo);
                \ensure_user_roles_schema($pdo);
                \ensure_service_providers_schema($pdo);
                \ensure_providers_schema($pdo);
            } catch (\Throwable $_) {
                // Non-fatal: if ensure fails, controller will still fall back to JSON store
            }

            // Role check
            $hasRole = false;
            try {
                $stmtRole = $pdo->prepare("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'users' AND column_name = 'role'");
                $stmtRole->execute();
                $hasRole = ((int)$stmtRole->fetchColumn() > 0);
            } catch (\Throwable $_) { $hasRole = false; }

            // Choose provider details source: service_providers preferred, else providers
            $providerSelect = 'NULL AS rating, NULL AS status, NULL AS skills';
            $providerJoin = '';
            $statusFilterCol = null;
            try {
                $pdo->query('SELECT 1 FROM service_providers LIMIT 1');
                $providerSelect = 'sp.rating AS rating, NULL AS status, NULL AS skills';
                $providerJoin = 'LEFT JOIN service_providers sp ON sp.user_id = u.id';
                $statusFilterCol = null; // no status field in service_providers typically
            } catch (\Throwable $e) {
                try {
                    $pdo->query('SELECT 1 FROM providers LIMIT 1');
                    $providerSelect = 'p.rating AS rating, p.status AS status, p.service_categories AS skills';
                    $providerJoin = 'LEFT JOIN providers p ON p.user_id = u.id';
                    $statusFilterCol = 'p.status';
                } catch (\Throwable $e2) {
                    $providerSelect = 'NULL AS rating, NULL AS status, NULL AS skills';
                    $providerJoin = '';
                    $statusFilterCol = null;
                }
            }

            $base = $hasRole
                ? 'FROM users u WHERE u.role = :role'
                : 'FROM users u JOIN user_roles r ON r.user_id = u.id AND r.role = :role';
            $clauses = [];
            $params = [ ':role' => 'provider' ];
            if ($search !== '') {
                $clauses[] = '(u.name LIKE :q OR u.email LIKE :q)';
                $params[':q'] = '%' . $search . '%';
            }
            if ($status !== 'all' && $statusFilterCol) {
                $clauses[] = 'LOWER(' . $statusFilterCol . ') = :status';
                $params[':status'] = $status;
            }
            $where = $clauses ? (' AND ' . implode(' AND ', $clauses)) : '';

            $sqlCount = 'SELECT COUNT(*) AS c ' . $base . $where;
            $stmtCount = $pdo->prepare($sqlCount);
            foreach ($params as $k => $v) { $stmtCount->bindValue($k, $v); }
            $stmtCount->execute();
            $total = (int)($stmtCount->fetchColumn() ?: 0);

            // Build final SQL with optional provider join
            if ($hasRole) {
                $sql = 'SELECT u.id, u.name, u.created_at, ' . $providerSelect . '
                        FROM users u ' . $providerJoin . '
                        WHERE u.role = :role ' . ($clauses ? (' AND ' . implode(' AND ', $clauses)) : '') . '
                        ORDER BY u.created_at DESC LIMIT :limit OFFSET :offset';
            } else {
                $sql = 'SELECT u.id, u.name, u.created_at, ' . $providerSelect . '
                        FROM users u JOIN user_roles r ON r.user_id = u.id AND r.role = :role ' . $providerJoin . '
                        ' . ($clauses ? (' WHERE ' . implode(' AND ', $clauses)) : '') . '
                        ORDER BY u.created_at DESC LIMIT :limit OFFSET :offset';
            }

            $stmt = $pdo->prepare($sql);
            foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
            foreach ($rows as &$row) {
                $row['status'] = self::normalizeStatus($row['status'] ?? 'active');
                $row['rating_fmt'] = isset($row['rating']) && $row['rating'] !== null ? number_format((float)$row['rating'], 1) . '/5' : '—';
                if (!empty($row['skills'])) {
                    $skills = json_decode($row['skills'], true);
                    if (is_array($skills) && !empty($skills)) { $row['skills'] = implode(', ', array_slice($skills, 0, 3)); } else { $row['skills'] = '-'; }
                } else { $row['skills'] = $row['skills'] ?? '-'; }
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
            // Fallback: providers.json
            $storeFile = \BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'providers.json';
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
                    $hay = strtolower(($it['name'] ?? '') . ' ' . ($it['skills'] ?? '') . ' ' . ($it['email'] ?? '') . ' ' . ($it['phone'] ?? ''));
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