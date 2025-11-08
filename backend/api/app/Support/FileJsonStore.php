<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class FileJsonStore
{
    private string $path;
    private $default;
    private string $driver;

    public function __construct(string $path, $default = [])
    {
        $this->path = $path;
        $this->default = $default;
        $this->driver = env('STORE_DRIVER', 'file');
        if ($this->driver === 'file') {
            $dir = dirname($this->path);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            if (!is_file($this->path)) {
                $this->write($default);
            }
        } else {
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
        }
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
        }
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
}