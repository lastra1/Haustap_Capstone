<?php
namespace App\Controllers\Admin;

final class ProvidersController {
    private string $storeFile;

    public function __construct() {
        $this->storeFile = \BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'providers.json';
    }

    private function loadStore(): array {
        if (is_file($this->storeFile)) {
            $raw = @file_get_contents($this->storeFile);
            $data = json_decode($raw ?: '[]', true);
            if (is_array($data)) { return $data; }
        }
        return [];
    }

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
        $items  = $this->loadStore();
        $status = isset($_GET['status']) ? strtolower(trim((string)$_GET['status'])) : 'all';
        $search = isset($_GET['search']) ? strtolower(trim((string)$_GET['search'])) : '';
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = isset($_GET['limit']) ? max(1, min(100, (int)$_GET['limit'])) : 10;

        $filtered = array_values(array_filter($items, function($it) use ($status, $search) {
            $itStatus = self::normalizeStatus($it['status'] ?? 'active');
            if ($status !== 'all' && $itStatus !== $status) { return false; }
            if ($search !== '') {
                $hay = strtolower(($it['name'] ?? '') . ' ' . ($it['skills'] ?? '') . ' ' . ($it['email'] ?? '') . ' ' . ($it['phone'] ?? ''));
                if (strpos($hay, $search) === false) { return false; }
            }
            return true;
        }));

        $total  = count($filtered);
        $offset = ($page - 1) * $limit;
        $paged  = array_slice($filtered, $offset, $limit);

        $this->json([
            'success' => true,
            'items'   => $paged,
            'page'    => $page,
            'limit'   => $limit,
            'total'   => $total,
        ]);
    }
}