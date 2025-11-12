<?php
namespace App\Controllers\Admin;

final class SystemController {
    private string $storageDir;
    private string $mockDataDir;

    public function __construct() {
        $this->storageDir = \BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'data';
        $this->mockDataDir = \BASE_PATH . DIRECTORY_SEPARATOR . 'mock-api' . DIRECTORY_SEPARATOR . '_data';
    }

    private function loadJson(string $file): array {
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

    // GET /api/admin/system/all
    public function all(): void {
        $analytics = $this->loadJson($this->storageDir . DIRECTORY_SEPARATOR . 'analytics.json');
        $applicants = $this->loadJson($this->storageDir . DIRECTORY_SEPARATOR . 'applicants.json');
        $bookings = $this->loadJson($this->mockDataDir . DIRECTORY_SEPARATOR . 'bookings.json');
        $vouchers = $this->loadJson($this->mockDataDir . DIRECTORY_SEPARATOR . 'vouchers.json');
        $referrals = $this->loadJson($this->mockDataDir . DIRECTORY_SEPARATOR . 'referrals.json');

        $this->json([
            'success' => true,
            'data' => [
                'analytics' => $analytics,
                'applicants' => $applicants,
                'bookings' => $bookings,
                'vouchers' => $vouchers,
                'referrals' => $referrals,
            ]
        ]);
    }

    // GET /api/admin/system/summary
    public function summary(): void {
        // DB-first: use existing admin data_gateway counters if available
        try {
            require_once \ADMIN_APP_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'db.php';
            require_once \ADMIN_APP_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'data_gateway.php';

            $summary = [
                'totalBookings' => (int) (\count_bookings() ?? 0),
                'pendingJobs' => (int) (\count_pending_jobs() ?? 0),
                'verifiedProviders' => (int) (\count_verified_providers() ?? 0),
                'totalClients' => (int) (\count_clients() ?? 0),
            ];

            $this->json(['success' => true, 'summary' => $summary, 'source' => 'db']);
            return;
        } catch (\Throwable $e) {
            // Fallback to JSON aggregates
        }

        $analytics = $this->loadJson($this->storageDir . DIRECTORY_SEPARATOR . 'analytics.json');
        $applicants = $this->loadJson($this->storageDir . DIRECTORY_SEPARATOR . 'applicants.json');
        $bookings = $this->loadJson($this->mockDataDir . DIRECTORY_SEPARATOR . 'bookings.json');
        $vouchers = $this->loadJson($this->mockDataDir . DIRECTORY_SEPARATOR . 'vouchers.json');
        $referrals = $this->loadJson($this->mockDataDir . DIRECTORY_SEPARATOR . 'referrals.json');

        $countBy = function(array $items, string $key): array {
            $counts = [];
            foreach ($items as $it) {
                $val = strtolower((string)($it[$key] ?? ''));
                if ($val === '') { $val = 'unknown'; }
                $counts[$val] = ($counts[$val] ?? 0) + 1;
            }
            return $counts;
        };

        $bookingCounts = $countBy($bookings, 'status');
        $voucherCounts = $countBy($vouchers, 'status');
        $applicantCounts = $countBy($applicants, 'status');

        $referralAccounts = count($referrals);
        $referralTotal = 0;
        foreach ($referrals as $r) {
            $referralTotal += is_array($r['referrals'] ?? null) ? count($r['referrals']) : 0;
        }

        $summary = [
            'totalBookings' => $analytics['totalBookings'] ?? count($bookings),
            'pendingJobs' => $analytics['pendingJobs'] ?? ($bookingCounts['pending'] ?? 0),
            'verifiedProviders' => $analytics['verifiedProviders'] ?? 0,
            'totalClients' => $analytics['totalClients'] ?? 0,
            'bookings' => [
                'total' => count($bookings),
                'pending' => $bookingCounts['pending'] ?? 0,
                'cancelled' => $bookingCounts['cancelled'] ?? 0,
                'ongoing' => $bookingCounts['ongoing'] ?? 0,
                'completed' => $bookingCounts['completed'] ?? 0,
            ],
            'vouchers' => [
                'total' => count($vouchers),
                'redeemed' => $voucherCounts['redeemed'] ?? 0,
                'expired' => $voucherCounts['expired'] ?? 0,
                'active' => $voucherCounts['active'] ?? 0,
            ],
            'applicants' => [
                'total' => count($applicants),
                'pending_review' => $applicantCounts['pending_review'] ?? 0,
                'scheduled' => $applicantCounts['scheduled'] ?? 0,
                'hired' => $applicantCounts['hired'] ?? 0,
                'rejected' => $applicantCounts['rejected'] ?? 0,
            ],
            'referrals' => [
                'accounts' => $referralAccounts,
                'total_referrals' => $referralTotal,
            ],
        ];

        $this->json(['success' => true, 'summary' => $summary, 'source' => 'json']);
    }

    public function categories(): void {
        $fallback = [
            [ 'slug' => 'cleaning', 'name' => 'Cleaning Services', 'description' => 'Professional and reliable cleaning to keep your space at its best.' ],
            [ 'slug' => 'outdoor', 'name' => 'Outdoor Services', 'description' => 'Expert gardening and outdoor care services for beautiful spaces.' ],
            [ 'slug' => 'repairs', 'name' => 'Home Repairs', 'description' => 'Quick and reliable repairs for home maintenance needs.' ],
            [ 'slug' => 'beauty', 'name' => 'Beauty Services', 'description' => 'Salon-quality beauty services from certified professionals.' ],
            [ 'slug' => 'wellness', 'name' => 'Wellness Services', 'description' => 'Relaxing wellness and self-care services at home.' ],
            [ 'slug' => 'tech', 'name' => 'Tech & Gadget Services', 'description' => 'Help with device setup, repairs, and smart home installations.' ],
        ];
        try {
            @require_once \BASE_PATH . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
            $envPath = \BASE_PATH . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . '.env';
            $env = [];
            if (is_file($envPath)) {
                foreach (@file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
                    $line = trim($line);
                    if ($line === '' || $line[0] === '#') continue;
                    $pos = strpos($line, '=');
                    if ($pos === false) continue;
                    $key = trim(substr($line, 0, $pos));
                    $val = trim(substr($line, $pos + 1));
                    $val = preg_replace('/^"|"$/', '', $val);
                    $val = preg_replace("/^'|'$/", '', $val);
                    $env[$key] = $val;
                }
            }
            $projectId = $env['FIREBASE_PROJECT_ID'] ?? getenv('FIREBASE_PROJECT_ID') ?? null;
            if ($projectId && class_exists('Google\\Auth\\ApplicationDefaultCredentials')) {
                $scopes = ['https://www.googleapis.com/auth/datastore'];
                $creds = \Google\Auth\ApplicationDefaultCredentials::getCredentials($scopes);
                $tokenInfo = $creds->fetchAuthToken();
                $accessToken = is_array($tokenInfo) ? ($tokenInfo['access_token'] ?? null) : null;
                if ($accessToken) {
                    $url = 'https://firestore.googleapis.com/v1/projects/' . $projectId . '/databases/(default)/documents/categories?pageSize=200';
                    $ctx = stream_context_create([
                        'http' => [
                            'method' => 'GET',
                            'header' => [
                                'Authorization: Bearer ' . $accessToken,
                                'Accept: application/json'
                            ],
                            'ignore_errors' => true,
                            'timeout' => 15
                        ]
                    ]);
                    $raw = @file_get_contents($url, false, $ctx);
                    $json = json_decode($raw ?: 'null', true);
                    $items = [];
                    $docs = is_array($json['documents'] ?? null) ? $json['documents'] : [];
                    foreach ($docs as $d) {
                        $f = $d['fields'] ?? [];
                        $slug = (string)($f['slug']['stringValue'] ?? '');
                        $name = (string)($f['name']['stringValue'] ?? '');
                        $desc = (string)($f['description']['stringValue'] ?? '');
                        if ($slug === '') {
                            $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($name));
                            $slug = trim($slug, '-');
                        }
                        if ($name !== '') {
                            $items[] = ['slug' => $slug ?: $name, 'name' => $name, 'description' => $desc];
                        }
                    }
                    if (!empty($items)) {
                        $this->json(['success' => true, 'categories' => $items, 'source' => 'firestore']);
                        return;
                    }
                }
            }
        } catch (\Throwable $e) {
        }
        try {
            require_once \ADMIN_APP_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'db.php';
            $pdo = \get_db();
            $stmt = $pdo->query('SELECT service_categories FROM providers WHERE service_categories IS NOT NULL');
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
            $unique = [];
            foreach ($rows as $r) {
                $cats = json_decode((string)($r['service_categories'] ?? '[]'), true);
                if (!is_array($cats)) continue;
                foreach ($cats as $c) {
                    $name = '';
                    $desc = '';
                    if (is_string($c)) { $name = trim($c); }
                    elseif (is_array($c)) { $name = trim((string)($c['name'] ?? '')); $desc = trim((string)($c['description'] ?? '')); }
                    if ($name === '') continue;
                    $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($name));
                    $slug = trim($slug, '-');
                    if ($slug === '') continue;
                    if (!isset($unique[$slug])) { $unique[$slug] = ['slug' => $slug, 'name' => $name, 'description' => $desc]; }
                }
            }
            $result = array_values($unique);
            if (empty($result)) $result = $fallback;
            $this->json(['success' => true, 'categories' => $result, 'source' => empty($unique) ? 'fallback' : 'db']);
            return;
        } catch (\Throwable $e) {
        }
        $this->json(['success' => true, 'categories' => $fallback, 'source' => 'fallback']);
    }
}
