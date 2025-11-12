<?php
namespace App\Controllers\Admin;

final class BookingsController {
    private string $mockDataDir;

    public function __construct() {
        $this->mockDataDir = \BASE_PATH . DIRECTORY_SEPARATOR . 'mock-api' . DIRECTORY_SEPARATOR . '_data';
    }

    private function loadBookings(): array {
        $file = $this->mockDataDir . DIRECTORY_SEPARATOR . 'bookings.json';
        if (is_file($file)) {
            $raw = @file_get_contents($file);
            $data = json_decode($raw ?: '[]', true);
            if (is_array($data)) { return $data; }
        }
        return [];
    }

    private function json(array $payload, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    // GET /api/admin/bookings?status=all&search=&page=1&limit=10
    public function index(): void {
        $items = $this->loadBookings();

        $status = isset($_GET['status']) ? strtolower(trim((string)$_GET['status'])) : 'all';
        $search = isset($_GET['search']) ? strtolower(trim((string)$_GET['search'])) : '';
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = isset($_GET['limit']) ? max(1, min(100, (int)$_GET['limit'])) : 10;

        $filtered = array_values(array_filter($items, function($it) use ($status, $search) {
            $itStatus = strtolower((string)($it['status'] ?? ''));
            if ($status !== 'all' && $itStatus !== $status) { return false; }
            if ($search !== '') {
                $hay = strtolower(($it['service_name'] ?? '') . ' ' . ($it['address'] ?? '') . ' ' . ($it['notes'] ?? ''));
                if (strpos($hay, $search) === false) { return false; }
            }
            return true;
        }));

        $total = count($filtered);
        $offset = ($page - 1) * $limit;
        $paged = array_slice($filtered, $offset, $limit);

        $this->json([
            'success' => true,
            'items' => $paged,
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
        ]);
    }
}