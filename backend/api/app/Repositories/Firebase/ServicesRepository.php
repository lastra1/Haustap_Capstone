<?php
namespace App\Repositories\Firebase;

use App\Services\Firebase\FirestoreClient;

class ServicesRepository
{
    public function __construct(private FirestoreClient $fs) {}

    public function list(): array
    {
        $resp = $this->fs->list('services', 200);
        $docs = is_array($resp['documents'] ?? null) ? $resp['documents'] : [];
        $out = [];
        foreach ($docs as $d) {
            $namePath = (string)($d['name'] ?? '');
            $id = ($namePath && str_contains($namePath, '/documents/services/'))
                ? substr($namePath, strrpos($namePath, '/') + 1)
                : null;
            $f = $d['fields'] ?? [];
            $price = isset($f['price']['doubleValue']) ? (float)$f['price']['doubleValue']
                : (isset($f['price']['integerValue']) ? (float)$f['price']['integerValue'] : 0);
            $variantsRaw = (array)($f['variants']['arrayValue']['values'] ?? []);
            $variants = [];
            foreach ($variantsRaw as $v) {
                $vf = (array)($v['mapValue']['fields'] ?? []);
                $vp = isset($vf['price']['doubleValue']) ? (float)$vf['price']['doubleValue']
                    : (isset($vf['price']['integerValue']) ? (float)$vf['price']['integerValue'] : 0);
                $variants[] = [
                    'name' => (string)($vf['name']['stringValue'] ?? ''),
                    'price' => $vp,
                    'unit' => (string)($vf['unit']['stringValue'] ?? ''),
                    'team_size' => isset($vf['team_size']['integerValue']) ? (int)$vf['team_size']['integerValue'] : 0
                ];
            }
            $out[] = [
                'id' => $id,
                'category_slug' => (string)($f['category_slug']['stringValue'] ?? ''),
                'name' => (string)($f['name']['stringValue'] ?? ''),
                'price' => $price,
                'unit' => (string)($f['unit']['stringValue'] ?? ''),
                'variants' => $variants,
                'team_size' => isset($f['team_size']['integerValue']) ? (int)$f['team_size']['integerValue'] : 0
            ];
        }
        return $out;
    }

    public function create(array $in, ?string $id = null): ?string
    {
        $variantsIn = (array)($in['variants'] ?? []);
        $variants = [];
        foreach ($variantsIn as $v) {
            $vp = isset($v['price']) ? (float)$v['price'] : 0;
            $variants[] = [
                'mapValue' => [
                    'fields' => [
                        'name' => ['stringValue' => (string)($v['name'] ?? '')],
                        'price' => ['doubleValue' => $vp],
                        'unit' => ['stringValue' => (string)($v['unit'] ?? '')],
                        'team_size' => ['integerValue' => isset($v['team_size']) ? (int)$v['team_size'] : 0]
                    ]
                ]
            ];
        }
        $fields = [
            'category_slug' => ['stringValue' => (string)($in['category_slug'] ?? '')],
            'name' => ['stringValue' => (string)($in['name'] ?? '')],
            'price' => ['doubleValue' => isset($in['price']) ? (float)$in['price'] : 0],
            'unit' => ['stringValue' => (string)($in['unit'] ?? '')],
            'variants' => ['arrayValue' => ['values' => $variants]],
            'team_size' => ['integerValue' => isset($in['team_size']) ? (int)$in['team_size'] : 0]
        ];
        $doc = $this->fs->create('services', $fields, $id);
        $namePath = is_array($doc) ? (string)($doc['name'] ?? '') : '';
        return ($namePath && str_contains($namePath, '/documents/services/'))
            ? substr($namePath, strrpos($namePath, '/') + 1)
            : null;
    }
}
