<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class FileJsonStore
{
    private string $path;
    private $default;

    public function __construct(string $path, $default = [])
    {
        $this->path = $path;
        $this->default = $default;
        $dir = dirname($this->path);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        if (!is_file($this->path)) {
            $this->write($default);
        }
    }

    public function read()
    {
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

    public function write($data): void
    {
        $tmp = $this->path . '.tmp';
        @file_put_contents($tmp, json_encode($data, JSON_PRETTY_PRINT));
        @rename($tmp, $this->path);
    }
}