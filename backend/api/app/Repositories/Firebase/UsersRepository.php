<?php
namespace App\Repositories\Firebase;

use App\Services\Firebase\FirestoreClient;

class UsersRepository
{
    public function __construct(private FirestoreClient $fs) {}

    public function list(): array
    {
        $resp = $this->fs->list('users', 100);
        $docs = is_array($resp['documents'] ?? null) ? $resp['documents'] : [];
        $out = [];
        foreach ($docs as $d) {
            $namePath = (string)($d['name'] ?? '');
            $id = ($namePath && str_contains($namePath, '/documents/users/'))
                ? substr($namePath, strrpos($namePath, '/') + 1)
                : null;
            $f = $d['fields'] ?? [];
            $roles = (array)($f['roles']['arrayValue']['values'] ?? []);
            $out[] = [
                'id' => $id,
                'email' => (string)($f['email']['stringValue'] ?? ''),
                'name' => (string)($f['name']['stringValue'] ?? ''),
                'roles' => array_map(function($v){ return (string)($v['stringValue'] ?? ''); }, $roles)
            ];
        }
        return $out;
    }

    public function create(array $in, ?string $id = null): ?string
    {
        $roles = (array)($in['roles'] ?? []);
        $primaryRole = (string)($in['role'] ?? (count($roles) ? (string)$roles[0] : ''));
        $fields = [
            'email' => ['stringValue' => (string)($in['email'] ?? '')],
            'name' => ['stringValue' => (string)($in['name'] ?? '')],
            'role' => $primaryRole !== '' ? ['stringValue' => $primaryRole] : ['stringValue' => 'client'],
            'roles' => ['arrayValue' => ['values' => array_map(fn($s) => ['stringValue' => (string)$s], $roles )]]
        ];
        $doc = $this->fs->create('users', $fields, $id);
        $namePath = is_array($doc) ? (string)($doc['name'] ?? '') : '';
        return ($namePath && str_contains($namePath, '/documents/users/'))
            ? substr($namePath, strrpos($namePath, '/') + 1)
            : null;
    }

    public function setRoles(string $id, array $roles, ?string $primaryRole = null): bool
    {
        $fields = [
            'roles' => ['arrayValue' => ['values' => array_map(fn($s) => ['stringValue' => (string)$s], $roles )]]
        ];
        if ($primaryRole !== null && $primaryRole !== '') {
            $fields['role'] = ['stringValue' => $primaryRole];
        }
        return $this->fs->patch('users', $id, $fields);
    }

    public function exists(string $id): bool
    {
        $doc = $this->fs->get('users', $id);
        return !empty($doc);
    }
}
