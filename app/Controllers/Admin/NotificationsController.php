<?php
namespace App\Controllers\Admin;

final class NotificationsController {
    private function json(array $payload, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function normalizeStatus(?string $s): string {
        $s = strtolower(trim((string)($s ?? '')));
        if ($s === '' || $s === 'pending' || $s === 'review') { return 'pending_review'; }
        return str_replace(' ', '_', $s);
    }

    private function tableExists(\PDO $pdo, string $table): bool {
        try {
            $driver = $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);
            if ($driver === 'sqlite') {
                $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name = ?");
                $stmt->execute([$table]);
                return (bool)$stmt->fetchColumn();
            }
            // mysql
            $stmt = $pdo->prepare('SELECT COUNT(*) AS c FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?');
            $stmt->execute([$table]);
            $row = $stmt->fetch();
            return ($row && (int)$row['c'] > 0);
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function computeCounts(): array {
        // Try DB first via admin API helper
        try {
            require_once \BASE_PATH . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '_lib' . DIRECTORY_SEPARATOR . 'db.php';
            $pdo = \db_connect();
            \ensure_applicants_schema($pdo);

            $pendingApplicants = 0;
            try {
                $stmt = $pdo->query("SELECT COUNT(*) AS c FROM admin_applicants WHERE LOWER(REPLACE(status, ' ', '_')) = 'pending_review'");
                $row = $stmt->fetch();
                $pendingApplicants = $row ? (int)$row['c'] : 0;
            } catch (\Throwable $e) {}

            $pendingBookings = 0;
            try {
                if ($this->tableExists($pdo, 'bookings')) {
                    $stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM bookings WHERE status = ?");
                    $stmt->execute(['pending']);
                    $row = $stmt->fetch();
                    $pendingBookings = $row ? (int)$row['c'] : 0;
                }
            } catch (\Throwable $e) {}

            $total = $pendingApplicants + $pendingBookings;
            return [
                'source' => 'db',
                'counts' => [
                    'applicants_pending' => $pendingApplicants,
                    'bookings_pending' => $pendingBookings,
                ],
                'total' => $total,
            ];
        } catch (\Throwable $e) {
            // Fallback to JSON stores
            $applicantsFile = \BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'applicants.json';
            $bookingsFile = \BASE_PATH . DIRECTORY_SEPARATOR . 'mock-api' . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . 'bookings.json';
            $pendingApplicants = 0; $pendingBookings = 0;
            try {
                if (is_file($applicantsFile)) {
                    $raw = @file_get_contents($applicantsFile) ?: '[]';
                    $items = json_decode($raw, true) ?: [];
                    foreach ($items as $it) {
                        $st = $this->normalizeStatus($it['status'] ?? 'pending_review');
                        if ($st === 'pending_review') { $pendingApplicants++; }
                    }
                }
            } catch (\Throwable $e2) {}
            try {
                if (is_file($bookingsFile)) {
                    $raw = @file_get_contents($bookingsFile) ?: '[]';
                    $items = json_decode($raw, true) ?: [];
                    foreach ($items as $it) {
                        $st = strtolower(trim((string)($it['status'] ?? '')));
                        if ($st === 'pending') { $pendingBookings++; }
                    }
                }
            } catch (\Throwable $e3) {}
            $total = $pendingApplicants + $pendingBookings;
            return [
                'source' => 'json',
                'counts' => [
                    'applicants_pending' => $pendingApplicants,
                    'bookings_pending' => $pendingBookings,
                ],
                'total' => $total,
            ];
        }
    }

    // GET /api/admin/notifications/unread_count
    public function unreadCount(): void {
        $payload = $this->computeCounts();
        $payload['success'] = true;
        $this->json($payload, 200);
    }

    // GET /api/admin/notifications/stream (Server-Sent Events)
    public function stream(): void {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        // Allow CORS in dev
        header('Access-Control-Allow-Origin: *');

        // Send a retry directive for EventSource
        echo "retry: 3000\n\n";
        @ob_end_flush(); @flush();

        // Stream for ~2 minutes in dev; clients will reconnect as needed
        $iterations = 40; // 40 * 3s ~= 120s
        for ($i = 0; $i < $iterations; $i++) {
            $payload = $this->computeCounts();
            $payload['success'] = true;
            $payload['ts'] = time();
            echo "event: unread_count\n";
            echo 'data: ' . json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n";
            echo 'id: ' . $payload['ts'] . "\n\n";
            @ob_end_flush(); @flush();
            usleep(3000000); // 3 seconds
        }
        // End the stream politely
        echo "event: done\n";
        echo "data: {\"success\":true}\n\n";
        @ob_end_flush(); @flush();
    }

    // DEV: Seed pending applicants to demonstrate live bell updates
    // GET /api/admin/dev/seed/applicants?count=1&status=pending_review
    public function seedApplicants(): void {
        try {
            require_once \BASE_PATH . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '_lib' . DIRECTORY_SEPARATOR . 'db.php';
            $pdo = \db_connect();
            \ensure_applicants_schema($pdo);

            $count = isset($_GET['count']) ? max(1, min(100, (int)$_GET['count'])) : 1;
            $status = isset($_GET['status']) ? $this->normalizeStatus((string)$_GET['status']) : 'pending_review';

            $stmt = $pdo->prepare("INSERT INTO admin_applicants (name, email, phone, applied_at, status) VALUES (?, ?, ?, ?, ?)");
            $now = date('Y-m-d');
            for ($i = 0; $i < $count; $i++) {
                $name = 'Seed Applicant ' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
                $email = strtolower(str_replace(' ', '', $name)) . '@example.test';
                $phone = '+1-555-' . str_pad((string)random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
                $stmt->execute([$name, $email, $phone, $now, $status]);
            }

            $payload = $this->computeCounts();
            $payload['success'] = true;
            $payload['seeded'] = [ 'type' => 'applicants', 'count' => $count, 'status' => $status ];
            $this->json($payload, 200);
            return;
        } catch (\Throwable $e) {
            $this->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // DEV: Seed pending bookings to demonstrate live bell updates
    // GET /api/admin/dev/seed/bookings?count=1&status=pending
    public function seedBookings(): void {
        try {
            require_once \BASE_PATH . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'admin_haustap' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '_lib' . DIRECTORY_SEPARATOR . 'db.php';
            $pdo = \db_connect();
            \ensure_bookings_schema($pdo);

            $count = isset($_GET['count']) ? max(1, min(100, (int)$_GET['count'])) : 1;
            $status = isset($_GET['status']) ? strtolower(trim((string)$_GET['status'])) : 'pending';

            $stmt = $pdo->prepare("INSERT INTO bookings (client_id, provider_id, service_name, scheduled_date, scheduled_time, status) VALUES (?, ?, ?, ?, ?, ?)");
            for ($i = 0; $i < $count; $i++) {
                $service = 'Seed Clean ' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
                $date = date('Y-m-d');
                $time = sprintf('%02d:%02d', random_int(8, 18), random_int(0, 59));
                $stmt->execute([null, null, $service, $date, $time, $status]);
            }

            $payload = $this->computeCounts();
            $payload['success'] = true;
            $payload['seeded'] = [ 'type' => 'bookings', 'count' => $count, 'status' => $status ];
            $this->json($payload, 200);
            return;
        } catch (\Throwable $e) {
            $this->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}

?>