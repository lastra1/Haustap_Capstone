<?php
namespace App\Repositories\Firebase;

use App\Services\Firebase\FirestoreClient;

class ApplicantsRepository
{
    public function __construct(private FirestoreClient $fs) {}

    public function list(): array
    {
        $resp = $this->fs->list('applicants', 100);
        $docs = is_array($resp['documents'] ?? null) ? $resp['documents'] : [];
        $out = [];
        foreach ($docs as $d) {
            $namePath = (string)($d['name'] ?? '');
            $id = ($namePath && str_contains($namePath, '/documents/applicants/'))
                ? substr($namePath, strrpos($namePath, '/') + 1)
                : null;
            $f = $d['fields'] ?? [];
            $values = (array)($f['categories']['arrayValue']['values'] ?? []);
            $cats = array_map(function($v){ return (string)($v['stringValue'] ?? ''); }, $values);
            $out[] = [
                'id' => $id,
                'name' => (string)($f['name']['stringValue'] ?? ''),
                'email' => (string)($f['email']['stringValue'] ?? ''),
                'phone' => (string)($f['phone']['stringValue'] ?? ''),
                'experience' => (string)($f['experience']['stringValue'] ?? ''),
                'categories' => $cats,
                'status' => (string)($f['status']['stringValue'] ?? 'pending')
            ];
        }
        return $out;
    }

    public function create(array $in): ?string
    {
        $fields = [
            'name' => ['stringValue' => (string)($in['name'] ?? '')],
            'email' => ['stringValue' => (string)($in['email'] ?? '')],
            'phone' => ['stringValue' => (string)($in['phone'] ?? '')],
            'experience' => ['stringValue' => (string)($in['experience'] ?? '')],
            'categories' => ['arrayValue' => ['values' => array_map(fn($s) => ['stringValue' => (string)$s], (array)($in['categories'] ?? []) )]],
            'status' => ['stringValue' => (string)($in['status'] ?? 'pending')]
        ];
        $doc = $this->fs->create('applicants', $fields);
        $namePath = is_array($doc) ? (string)($doc['name'] ?? '') : '';
        return ($namePath && str_contains($namePath, '/documents/applicants/'))
            ? substr($namePath, strrpos($namePath, '/') + 1)
            : null;
    }

    public function setStatus(string $id, string $status): bool
    {
        return $this->fs->patch('applicants', $id, ['status' => ['stringValue' => $status]]);
    }

    public function get(string $id): array
    {
        $doc = $this->fs->get('applicants', $id);
        $f = $doc['fields'] ?? [];
        $values = (array)($f['categories']['arrayValue']['values'] ?? []);
        return [
            'id' => $id,
            'name' => (string)($f['name']['stringValue'] ?? ''),
            'email' => (string)($f['email']['stringValue'] ?? ''),
            'phone' => (string)($f['phone']['stringValue'] ?? ''),
            'experience' => (string)($f['experience']['stringValue'] ?? ''),
            'categories' => array_map(function($v){ return (string)($v['stringValue'] ?? ''); }, $values),
            'status' => (string)($f['status']['stringValue'] ?? 'pending')
        ];
    }
}
