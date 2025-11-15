<?php
namespace App\Controllers\Admin;

final class BookingsController {
    private function json(array $payload, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    // GET /api/admin/bookings?status=all&search=&page=1&limit=10
    public function index(): void {
        $status = isset($_GET['status']) ? strtolower(trim((string)$_GET['status'])) : 'all';
        $search = isset($_GET['search']) ? trim((string)$_GET['search']) : '';
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = isset($_GET['limit']) ? max(1, min(100, (int)$_GET['limit'])) : 10;
        $offset = ($page - 1) * $limit;

        // Try DB first, fallback to mock JSON on failure
        try {
            require_once \BASE_PATH . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '_lib' . DIRECTORY_SEPARATOR . 'db.php';
            $pdo = \db_connect();

            // Ensure bookings/users tables exist for new environments
            try {
                \ensure_users_schema($pdo);
                \ensure_bookings_schema($pdo);
            } catch (\Throwable $_) {
                // Continue; fallback to mock JSON will handle if DB setup fails
            }

            // Build dynamic joins based on available tables (users, providers/service_providers)
            $selectProvider = 'up.name AS provider_name';
            $joinProvider = '';
            $joinProviderUser = 'LEFT JOIN users up ON up.id = b.provider_id';
            try {
                // Prefer service_providers for provider profile; join via user_id
                $pdo->query('SELECT 1 FROM service_providers LIMIT 1');
                $selectProvider = 'COALESCE(sp.company_name, up.name) AS provider_name';
                $joinProvider = 'LEFT JOIN service_providers sp ON sp.user_id = b.provider_id';
            } catch (\Throwable $e) {
                // Fallback to legacy providers table; join via user_id
                try {
                    $pdo->query('SELECT 1 FROM providers LIMIT 1');
                    // providers table may not have name/company_name; rely on up.name
                    $selectProvider = 'up.name AS provider_name';
                    $joinProvider = 'LEFT JOIN providers p ON p.user_id = b.provider_id';
                } catch (\Throwable $e2) {
                    $selectProvider = 'up.name AS provider_name';
                    $joinProvider = '';
                }
            }

            // Status filter mapping: ignore `return` in DB list for now
            $clauses = [];
            $params = [];
            if ($status !== 'all' && $status !== 'return') {
                $clauses[] = 'LOWER(b.status) = :status';
                $params[':status'] = strtolower($status);
            }
            if ($search !== '') {
                $clauses[] = '(
                    LOWER(b.service_name) LIKE :q OR LOWER(b.address) LIKE :q OR LOWER(b.notes) LIKE :q OR
                    LOWER(u.name) LIKE :q OR LOWER(u.email) LIKE :q OR LOWER(up.name) LIKE :q' . (strpos($selectProvider, 'sp.company_name') !== false ? ' OR LOWER(sp.company_name) LIKE :q' : '') . '
                )';
                $params[':q'] = '%' . strtolower($search) . '%';
            }
            $where = $clauses ? ('WHERE ' . implode(' AND ', $clauses)) : '';

            // Count
            $sqlCount = "SELECT COUNT(*) AS c
                        FROM bookings b
                        LEFT JOIN users u ON u.id = b.client_id
                        {$joinProviderUser}
                        {$joinProvider}
                        {$where}";
            $stmtCount = $pdo->prepare($sqlCount);
            foreach ($params as $k => $v) { $stmtCount->bindValue($k, $v); }
            $stmtCount->execute();
            $total = (int)($stmtCount->fetchColumn() ?: 0);

            // Page
            $sql = "SELECT b.id, u.name AS client_name, {$selectProvider}, b.service_name, b.scheduled_date, b.scheduled_time, b.status
                    FROM bookings b
                    LEFT JOIN users u ON u.id = b.client_id
                    {$joinProviderUser}
                    {$joinProvider}
                    {$where}
                    ORDER BY b.id DESC
                    LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($sql);
            foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

            $this->json([
                'success' => true,
                'items' => $items,
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
            ]);
            return;
        } catch (\Throwable $e) {
            // Fallback: serve from mock JSON
            $mockFile = \BASE_PATH . DIRECTORY_SEPARATOR . 'mock-api' . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . 'bookings.json';
            $items = [];
            if (is_file($mockFile)) {
                $raw = @file_get_contents($mockFile);
                $data = json_decode($raw ?: '[]', true);
                if (is_array($data)) { $items = $data; }
            }

            $filtered = array_values(array_filter($items, function($it) use ($status, $search) {
                $itStatus = strtolower((string)($it['status'] ?? ''));
                if ($status !== 'all' && $status !== 'return' && $itStatus !== $status) { return false; }
                if ($search !== '') {
                    $hay = strtolower(($it['service_name'] ?? '') . ' ' . ($it['address'] ?? '') . ' ' . ($it['notes'] ?? ''));
                    if (strpos($hay, strtolower($search)) === false) { return false; }
                }
                return true;
            }));

            $total = count($filtered);
            $paged = array_slice($filtered, $offset, $limit);
            $this->json([
                'success' => true,
                'items' => $paged,
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'fallback' => 'mock_json',
            ]);
        }
    }
}