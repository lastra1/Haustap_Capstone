<?php
namespace App\Repositories\Firebase;

use App\Services\Firebase\FirestoreClient;

class BookingsRepository
{
    public function __construct(private FirestoreClient $fs) {}

    public function list(): array
    {
        $resp = $this->fs->list('bookings', 50);
        $docs = is_array($resp['documents'] ?? null) ? $resp['documents'] : [];
        $out = [];
        foreach ($docs as $d) {
            $namePath = (string)($d['name'] ?? '');
            $id = ($namePath && str_contains($namePath, '/documents/bookings/'))
                ? substr($namePath, strrpos($namePath, '/') + 1)
                : null;
            $f = $d['fields'] ?? [];
            $out[] = [
                'id' => $id,
                'provider_id' => (int)($f['provider_id']['integerValue'] ?? 0),
                'providerUid' => (string)($f['providerUid']['stringValue'] ?? ''),
                'clientUid' => (string)($f['clientUid']['stringValue'] ?? ''),
                'service_name' => (string)($f['service_name']['stringValue'] ?? ''),
                'scheduled_date' => (string)($f['scheduled_date']['stringValue'] ?? ''),
                'scheduled_time' => (string)($f['scheduled_time']['stringValue'] ?? ''),
                'address' => (string)($f['address']['stringValue'] ?? ''),
                'price' => isset($f['price']['doubleValue']) ? (float)$f['price']['doubleValue']
                    : (isset($f['price']['integerValue']) ? (float)$f['price']['integerValue'] : 0),
                'status' => (string)($f['status']['stringValue'] ?? 'pending'),
            ];
        }
        return $out;
    }

    public function create(array $in): ?string
    {
        $fields = [
            'provider_id' => ['integerValue' => (int)($in['provider_id'] ?? 0)],
            'providerUid' => ['stringValue' => (string)($in['providerUid'] ?? '')],
            'clientUid' => ['stringValue' => (string)($in['clientUid'] ?? '')],
            'service_name' => ['stringValue' => (string)($in['service_name'] ?? '')],
            'scheduled_date' => ['stringValue' => (string)($in['scheduled_date'] ?? '')],
            'scheduled_time' => ['stringValue' => (string)($in['scheduled_time'] ?? '')],
            'address' => ['stringValue' => (string)($in['address'] ?? '')],
            'lat' => ['doubleValue' => isset($in['lat']) ? (float)$in['lat'] : 0],
            'lng' => ['doubleValue' => isset($in['lng']) ? (float)$in['lng'] : 0],
            'price' => ['doubleValue' => isset($in['price']) ? (float)$in['price'] : 0],
            'service_items' => ['arrayValue' => ['values' => array_map(fn($s) => ['stringValue' => (string)$s], (array)($in['service_items'] ?? []) )]],
            'notes' => ['stringValue' => (string)($in['notes'] ?? '')],
            'status' => ['stringValue' => 'pending']
        ];
        $doc = $this->fs->create('bookings', $fields);
        $namePath = is_array($doc) ? (string)($doc['name'] ?? '') : '';
        return ($namePath && str_contains($namePath, '/documents/bookings/'))
            ? substr($namePath, strrpos($namePath, '/') + 1)
            : null;
    }

    public function setStatus(string $id, string $status): bool
    {
        return $this->fs->patch('bookings', $id, ['status' => ['stringValue' => $status]]);
    }

    public function cancel(string $id, string $reason): bool
    {
        return $this->fs->patch('bookings', $id, [
            'status' => ['stringValue' => 'cancelled'],
            'cancel_reason' => ['stringValue' => $reason]
        ]);
    }

    public function rate(string $id, float $rating): bool
    {
        return $this->fs->patch('bookings', $id, ['rating' => ['doubleValue' => $rating]]);
    }
}

