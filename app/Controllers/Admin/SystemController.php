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
            // From analytics.json (existing dashboard numbers)
            'totalBookings' => $analytics['totalBookings'] ?? count($bookings),
            'pendingJobs' => $analytics['pendingJobs'] ?? ($bookingCounts['pending'] ?? 0),
            'verifiedProviders' => $analytics['verifiedProviders'] ?? 0,
            'totalClients' => $analytics['totalClients'] ?? 0,

            // Additional breakdowns from raw datasets
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

        $this->json(['success' => true, 'data' => $summary]);
    }
}