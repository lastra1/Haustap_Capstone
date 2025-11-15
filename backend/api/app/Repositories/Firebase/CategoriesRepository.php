<?php
namespace App\Repositories\Firebase;

use App\Services\Firebase\FirestoreClient;

class CategoriesRepository
{
    public function __construct(private FirestoreClient $fs) {}

    public function list(): array
    {
        $resp = $this->fs->list('categories', 200);
        $docs = is_array($resp['documents'] ?? null) ? $resp['documents'] : [];
        $out = [];
        foreach ($docs as $d) {
            $f = $d['fields'] ?? [];
            $slug = (string)($f['slug']['stringValue'] ?? '');
            $name = (string)($f['name']['stringValue'] ?? '');
            $desc = (string)($f['description']['stringValue'] ?? '');
            $price = isset($f['price']['doubleValue']) ? (float)$f['price']['doubleValue']
                : (isset($f['price']['integerValue']) ? (float)$f['price']['integerValue'] : 0);
            $unit = (string)($f['unit']['stringValue'] ?? '');
            $variantsRaw = (array)($f['variants']['arrayValue']['values'] ?? []);
            $variants = [];
            foreach ($variantsRaw as $v) {
                $vf = (array)($v['mapValue']['fields'] ?? []);
                $vp = isset($vf['price']['doubleValue']) ? (float)$vf['price']['doubleValue']
                    : (isset($vf['price']['integerValue']) ? (float)$vf['price']['integerValue'] : 0);
                $variants[] = [
                    'name' => (string)($vf['name']['stringValue'] ?? ''),
                    'price' => $vp,
                    'unit' => (string)($vf['unit']['stringValue'] ?? '')
                ];
            }
            if ($name === '') continue;
            if ($slug === '') {
                $slug = trim(preg_replace('/[^a-z0-9]+/i', '-', strtolower($name)), '-');
            }
            $out[] = [
                'slug' => $slug ?: $name,
                'name' => $name,
                'description' => $desc,
                'price' => $price,
                'unit' => $unit,
                'variants' => $variants
            ];
        }
        return $out;
    }

    public function create(array $in, ?string $id = null): ?string
    {
        $slug = (string)($in['slug'] ?? '');
        $name = (string)($in['name'] ?? '');
        $desc = (string)($in['description'] ?? '');
        if ($slug === '') {
            $slug = trim(preg_replace('/[^a-z0-9]+/i', '-', strtolower($name)), '-');
        }
        $fields = [
            'slug' => ['stringValue' => $slug],
            'name' => ['stringValue' => $name],
            'description' => ['stringValue' => $desc]
        ];
        $doc = $this->fs->create('categories', $fields, $id ?? $slug);
        $namePath = is_array($doc) ? (string)($doc['name'] ?? '') : '';
        return ($namePath && str_contains($namePath, '/documents/categories/'))
            ? substr($namePath, strrpos($namePath, '/') + 1)
            : null;
    }

    public function get(string $slug): array
    {
        $doc = $this->fs->get('categories', $slug);
        $f = $doc['fields'] ?? [];
        $price = isset($f['price']['doubleValue']) ? (float)$f['price']['doubleValue']
            : (isset($f['price']['integerValue']) ? (float)$f['price']['integerValue'] : 0);
        $unit = (string)($f['unit']['stringValue'] ?? '');
        $variantsRaw = (array)($f['variants']['arrayValue']['values'] ?? []);
        $variants = [];
        foreach ($variantsRaw as $v) {
            $vf = (array)($v['mapValue']['fields'] ?? []);
            $vp = isset($vf['price']['doubleValue']) ? (float)$vf['price']['doubleValue']
                : (isset($vf['price']['integerValue']) ? (float)$vf['price']['integerValue'] : 0);
            $variants[] = [
                'name' => (string)($vf['name']['stringValue'] ?? ''),
                'price' => $vp,
                'unit' => (string)($vf['unit']['stringValue'] ?? '')
            ];
        }
        return [
            'slug' => (string)($f['slug']['stringValue'] ?? $slug),
            'name' => (string)($f['name']['stringValue'] ?? ''),
            'description' => (string)($f['description']['stringValue'] ?? ''),
            'price' => $price,
            'unit' => $unit,
            'variants' => $variants
        ];
    }

    public function setPrice(string $slug, float $price, string $unit = '', array $variants = []): bool
    {
        $vals = [];
        foreach ($variants as $v) {
            $vals[] = [
                'mapValue' => [
                    'fields' => [
                        'name' => ['stringValue' => (string)($v['name'] ?? '')],
                        'price' => ['doubleValue' => isset($v['price']) ? (float)$v['price'] : 0],
                        'unit' => ['stringValue' => (string)($v['unit'] ?? '')]
                    ]
                ]
            ];
        }
        return $this->fs->patch('categories', $slug, [
            'price' => ['doubleValue' => $price],
            'unit' => ['stringValue' => $unit],
            'variants' => ['arrayValue' => ['values' => $vals]]
        ]);
    }

    public function setProviderCount(string $slug, int $count): bool
    {
        return $this->fs->patch('categories', $slug, [
            'provider_count' => ['integerValue' => $count]
        ]);
    }
}
