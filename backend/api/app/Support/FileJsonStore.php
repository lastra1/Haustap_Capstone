<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Services\Firebase\FirestoreClient;

class FileJsonStore
{
    private string $path;
    private $default;
    private string $driver;
    private ?FirestoreClient $firestore = null;

    public function __construct(string $path, $default = [])
    {
        $this->path = $path;
        $this->default = $default;
        $this->driver = env('STORE_DRIVER', 'firestore');
        
        if ($this->driver === 'file') {
            $dir = dirname($this->path);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            if (!is_file($this->path)) {
                $this->write($default);
            }
        } elseif ($this->driver === 'firestore') {
            $this->firestore = app(FirestoreClient::class);
            // Firestore doesn't need initialization - it's ready when needed
        } else {
            // MySQL fallback
            try {
                $existing = DB::table('json_store')->where('path', $this->path)->first();
                if (!$existing) {
                    DB::table('json_store')->insert([
                        'path' => $this->path,
                        'payload' => json_encode($default, JSON_PRETTY_PRINT),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } catch (\Throwable $e) {
                // Fallback to file if DB not ready
                $this->driver = 'file';
                $dir = dirname($this->path);
                if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
                if (!is_file($this->path)) { $this->write($default); }
            }
        }
    }

    public function read()
    {
        if ($this->driver === 'file') {
            if (!is_file($this->path)) {
                return $this->default;
            }
            $raw = @file_get_contents($this->path);
            if ($raw === false) {
                return $this->default;
            }
            $data = json_decode($raw, true);
            return is_array($data) || is_object($data) ? $data : $this->default;
        } elseif ($this->driver === 'firestore') {
            try {
                $collection = $this->getFirestoreCollection();
                $document = $this->firestore->get($collection, $this->getDocumentId());
                
                if (empty($document)) {
                    return $this->default;
                }
                
                $fields = $document['fields'] ?? [];
                return $this->convertFirestoreFieldsToArray($fields);
            } catch (\Throwable $e) {
                return $this->default;
            }
        }
        
        // MySQL fallback
        try {
            $row = DB::table('json_store')->where('path', $this->path)->first();
            if (!$row || !isset($row->payload)) { return $this->default; }
            $data = json_decode($row->payload, true);
            return is_array($data) || is_object($data) ? $data : $this->default;
        } catch (\Throwable $e) {
            return $this->default;
        }
    }

    public function write($data): void
    {
        if ($this->driver === 'file') {
            $tmp = $this->path . '.tmp';
            @file_put_contents($tmp, json_encode($data, JSON_PRETTY_PRINT));
            @rename($tmp, $this->path);
            return;
        } elseif ($this->driver === 'firestore') {
            try {
                $collection = $this->getFirestoreCollection();
                $documentId = $this->getDocumentId();
                $fields = $this->convertArrayToFirestoreFields($data);
                
                $this->firestore->patch($collection, $documentId, $fields);
            } catch (\Throwable $e) {
                // Silent fail to avoid breaking endpoints; controllers handle defaults
            }
            return;
        }
        
        // MySQL fallback
        try {
            DB::table('json_store')->updateOrInsert(
                ['path' => $this->path],
                [
                    'payload' => json_encode($data, JSON_PRETTY_PRINT),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        } catch (\Throwable $e) {
            // Silent fail to avoid breaking endpoints; controllers handle defaults
        }
    }
    
    private function getFirestoreCollection(): string
    {
        // Extract collection name from path
        $parts = explode('/', trim($this->path, '/'));
        return $parts[0] ?? 'json_store';
    }
    
    private function getDocumentId(): string
    {
        // Extract document ID from path
        $parts = explode('/', trim($this->path, '/'));
        return end($parts) ?: 'default';
    }
    
    private function convertFirestoreFieldsToArray(array $fields): array
    {
        $result = [];
        foreach ($fields as $key => $field) {
            if (isset($field['stringValue'])) {
                $result[$key] = $field['stringValue'];
            } elseif (isset($field['integerValue'])) {
                $result[$key] = (int)$field['integerValue'];
            } elseif (isset($field['doubleValue'])) {
                $result[$key] = (float)$field['doubleValue'];
            } elseif (isset($field['booleanValue'])) {
                $result[$key] = (bool)$field['booleanValue'];
            } elseif (isset($field['arrayValue']['values'])) {
                $result[$key] = array_map(function($item) {
                    return $this->convertFirestoreFieldsToArray(['item' => $item])['item'] ?? null;
                }, $field['arrayValue']['values']);
            } elseif (isset($field['mapValue']['fields'])) {
                $result[$key] = $this->convertFirestoreFieldsToArray($field['mapValue']['fields']);
            } else {
                $result[$key] = null;
            }
        }
        return $result;
    }
    
    private function convertArrayToFirestoreFields($data): array
    {
        $fields = [];
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $fields[$key] = ['stringValue' => $value];
            } elseif (is_int($value)) {
                $fields[$key] = ['integerValue' => $value];
            } elseif (is_float($value)) {
                $fields[$key] = ['doubleValue' => $value];
            } elseif (is_bool($value)) {
                $fields[$key] = ['booleanValue' => $value];
            } elseif (is_array($value)) {
                if ($this->isAssociativeArray($value)) {
                    $fields[$key] = ['mapValue' => ['fields' => $this->convertArrayToFirestoreFields($value)]];
                } else {
                    $fields[$key] = ['arrayValue' => ['values' => array_map(function($item) {
                        return $this->convertScalarToFirestoreValue($item);
                    }, $value)]];
                }
            } elseif (is_null($value)) {
                $fields[$key] = ['nullValue' => null];
            }
        }
        return $fields;
    }
    
    private function isAssociativeArray(array $arr): bool
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
    
    private function convertScalarToFirestoreValue($value): array
    {
        if (is_string($value)) {
            return ['stringValue' => $value];
        } elseif (is_int($value)) {
            return ['integerValue' => $value];
        } elseif (is_float($value)) {
            return ['doubleValue' => $value];
        } elseif (is_bool($value)) {
            return ['booleanValue' => $value];
        } elseif (is_null($value)) {
            return ['nullValue' => null];
        }
        return ['stringValue' => (string)$value];
    }
}