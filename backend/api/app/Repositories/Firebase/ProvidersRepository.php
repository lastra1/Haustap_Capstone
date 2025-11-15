<?php
namespace App\Repositories\Firebase;

use App\Services\Firebase\FirestoreClient;

class ProvidersRepository
{
    public function __construct(private FirestoreClient $fs) {}

    public function list(): array
    {
        $resp = $this->fs->list('providers', 100);
        $docs = is_array($resp['documents'] ?? null) ? $resp['documents'] : [];
        $out = [];
        foreach ($docs as $d) {
            $namePath = (string)($d['name'] ?? '');
            $id = ($namePath && str_contains($namePath, '/documents/providers/'))
                ? substr($namePath, strrpos($namePath, '/') + 1)
                : null;
            $f = $d['fields'] ?? [];
            $nm = (string)($f['name']['stringValue'] ?? ($id ?? ''));
            $rating = isset($f['rating']['doubleValue']) ? (float)$f['rating']['doubleValue']
                : (isset($f['rating']['integerValue']) ? (float)$f['rating']['integerValue'] : 0);
            $distance = isset($f['distanceKm']['doubleValue']) ? (float)$f['distanceKm']['doubleValue']
                : (isset($f['distanceKm']['integerValue']) ? (float)$f['distanceKm']['integerValue'] : 0);
            $out[] = ['id' => $id, 'name' => $nm, 'rating' => $rating, 'distanceKm' => $distance];
        }
        return $out;
    }

    public function create(array $in, ?string $id = null): ?string
    {
        $values = array_map(fn($s) => ['stringValue' => (string)$s], (array)($in['service_categories'] ?? []));
        $fields = [
            'name' => ['stringValue' => (string)($in['name'] ?? '')],
            'rating' => ['doubleValue' => isset($in['rating']) ? (float)$in['rating'] : 0],
            'distanceKm' => ['doubleValue' => isset($in['distanceKm']) ? (float)$in['distanceKm'] : 0],
            'service_categories' => ['arrayValue' => ['values' => $values]]
        ];
        $doc = $this->fs->create('providers', $fields, $id);
        $namePath = is_array($doc) ? (string)($doc['name'] ?? '') : '';
        return ($namePath && str_contains($namePath, '/documents/providers/'))
            ? substr($namePath, strrpos($namePath, '/') + 1)
            : null;
    }
}
