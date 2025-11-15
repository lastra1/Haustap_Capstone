<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Kreait\Firebase\Factory;
use Exception;

class HealthController extends Controller
{
    /**
     * Comprehensive health check for HausTap API
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function health()
    {
        $checks = [];
        $overall_status = 'healthy';
        $http_code = 200;

        // Database Health Check
        $checks['database'] = $this->checkDatabase();
        if ($checks['database']['status'] !== 'healthy') {
            $overall_status = 'degraded';
            // Don't set 503 for database issues in development
        }

        // Cache Health Check
        $checks['cache'] = $this->checkCache();
        if ($checks['cache']['status'] !== 'healthy') {
            $overall_status = 'degraded';
        }

        // Queue Health Check
        $checks['queue'] = $this->checkQueue();
        if ($checks['queue']['status'] !== 'healthy') {
            $overall_status = 'degraded';
        }

        // Firebase Health Check (if configured)
        $checks['firebase'] = $this->checkFirebase();
        if ($checks['firebase']['status'] !== 'healthy') {
            $overall_status = 'degraded';
        }

        // Storage Health Check
        $checks['storage'] = $this->checkStorage();
        if ($checks['storage']['status'] !== 'healthy') {
            $overall_status = 'degraded';
        }

        // Application Info
        $app_info = [
            'name' => config('app.name'),
            'environment' => config('app.env'),
            'version' => $this->getAppVersion(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'timezone' => config('app.timezone'),
            'debug_mode' => config('app.debug'),
        ];

        $response = [
            'status' => $overall_status,
            'timestamp' => now()->toIso8601String(),
            'uptime' => $this->getUptime(),
            'checks' => $checks,
            'application' => $app_info,
            'services' => $this->getServiceStatus()
        ];

        return response()->json($response, $http_code);
    }

    /**
     * Basic health check (for load balancers)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function ping()
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'service' => config('app.name')
        ], 200);
    }

    /**
     * Check database connectivity
     * 
     * @return array
     */
    private function checkDatabase(): array
    {
        try {
            $start_time = microtime(true);
            
            // Test basic connection
            DB::connection()->getPdo();
            
            // Test query execution
            $result = DB::select('SELECT 1 as test');
            
            // Check migrations table exists (only if we can connect)
            try {
                $migration_count = DB::table('migrations')->count();
            } catch (Exception $e) {
                $migration_count = 0; // Table doesn't exist yet
            }
            
            $response_time = round((microtime(true) - $start_time) * 1000, 2);

            return [
                'status' => 'healthy',
                'message' => 'Database connection successful',
                'response_time_ms' => $response_time,
                'details' => [
                    'driver' => config('database.default'),
                    'migrations_count' => $migration_count,
                    'connection_name' => DB::connection()->getName()
                ]
            ];
        } catch (Exception $e) {
            return [
                'status' => 'degraded',
                'message' => 'Database connection failed',
                'error' => $e->getMessage(),
                'details' => [
                    'driver' => config('database.default'),
                    'host' => config('database.connections.' . config('database.default') . '.host'),
                    'port' => config('database.connections.' . config('database.default') . '.port')
                ]
            ];
        }
    }

    /**
     * Check cache connectivity
     * 
     * @return array
     */
    private function checkCache(): array
    {
        try {
            $start_time = microtime(true);
            
            // Test cache write/read
            $test_key = 'health_check_' . time();
            Cache::put($test_key, 'test_value', 60);
            $cached_value = Cache::get($test_key);
            Cache::forget($test_key);
            
            $response_time = round((microtime(true) - $start_time) * 1000, 2);

            if ($cached_value === 'test_value') {
                return [
                    'status' => 'healthy',
                    'message' => 'Cache connection successful',
                    'response_time_ms' => $response_time,
                    'details' => [
                        'driver' => config('cache.default'),
                        'test_key' => $test_key
                    ]
                ];
            } else {
                return [
                    'status' => 'unhealthy',
                    'message' => 'Cache read/write test failed'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => 'unhealthy',
                'message' => 'Cache connection failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check queue connectivity
     * 
     * @return array
     */
    private function checkQueue(): array
    {
        try {
            $connection = Queue::connection();
            $connection_name = config('queue.default');
            
            return [
                'status' => 'healthy',
                'message' => 'Queue connection available',
                'details' => [
                    'driver' => $connection_name,
                    'connection' => get_class($connection)
                ]
            ];
        } catch (Exception $e) {
            return [
                'status' => 'unhealthy',
                'message' => 'Queue connection failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check Firebase connectivity
     * 
     * @return array
     */
    private function checkFirebase(): array
    {
        try {
            // Check if Firebase is configured
            if (!config('services.firebase.project_id')) {
                return [
                    'status' => 'disabled',
                    'message' => 'Firebase not configured'
                ];
            }

            $factory = (new Factory)
                ->withServiceAccount(config('services.firebase.credentials'));
            
            $auth = $factory->createAuth();
            
            // Test Firebase connection by getting project info
            $project_info = $auth->getUser('test'); // This will throw if not configured
            
            return [
                'status' => 'healthy',
                'message' => 'Firebase connection successful',
                'details' => [
                    'project_id' => config('services.firebase.project_id'),
                    'service_account' => config('services.firebase.client_email')
                ]
            ];
        } catch (Exception $e) {
            return [
                'status' => 'unhealthy',
                'message' => 'Firebase connection failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check storage connectivity
     * 
     * @return array
     */
    private function checkStorage(): array
    {
        try {
            $disk = config('filesystems.default');
            $storage_path = storage_path('app');
            
            // Test storage write/read
            $test_file = 'health_check_' . time() . '.txt';
            $test_content = 'Health check test ' . time();
            
            \Storage::disk('local')->put($test_file, $test_content);
            $stored_content = \Storage::disk('local')->get($test_file);
            \Storage::disk('local')->delete($test_file);
            
            if ($stored_content === $test_content) {
                return [
                    'status' => 'healthy',
                    'message' => 'Storage connection successful',
                    'details' => [
                        'disk' => $disk,
                        'storage_path' => $storage_path,
                        'test_file' => $test_file
                    ]
                ];
            } else {
                return [
                    'status' => 'unhealthy',
                    'message' => 'Storage read/write test failed'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => 'unhealthy',
                'message' => 'Storage connection failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get application uptime
     * 
     * @return string
     */
    private function getUptime(): string
    {
        try {
            $uptime_file = storage_path('framework/uptime');
            
            if (file_exists($uptime_file)) {
                $start_time = file_get_contents($uptime_file);
                $uptime_seconds = time() - (int)$start_time;
                
                return $this->formatUptime($uptime_seconds);
            }
            
            // Create uptime file if it doesn't exist
            file_put_contents($uptime_file, time());
            return '0 seconds';
        } catch (Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Format uptime in human readable format
     * 
     * @param int $seconds
     * @return string
     */
    private function formatUptime(int $seconds): string
    {
        $units = [
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1
        ];

        foreach ($units as $unit => $value) {
            if ($seconds >= $value) {
                $count = floor($seconds / $value);
                return $count . ' ' . $unit . ($count > 1 ? 's' : '');
            }
        }

        return '0 seconds';
    }

    /**
     * Get application version
     * 
     * @return string
     */
    private function getAppVersion(): string
    {
        try {
            $version_file = base_path('VERSION');
            if (file_exists($version_file)) {
                return trim(file_get_contents($version_file));
            }
            
            // Try to get from git
            $git_version = shell_exec('git describe --tags --always 2>/dev/null');
            if ($git_version) {
                return trim($git_version);
            }
            
            return '1.0.0';
        } catch (Exception $e) {
            return '1.0.0';
        }
    }

    /**
     * Get service status summary
     * 
     * @return array
     */
    private function getServiceStatus(): array
    {
        return [
            'authentication' => [
                'enabled' => true,
                'driver' => 'sanctum',
                'multi_device' => true
            ],
            'notifications' => [
                'enabled' => true,
                'channels' => ['database', 'mail']
            ],
            'location_services' => [
                'enabled' => true,
                'geocoding' => true
            ],
            'file_uploads' => [
                'enabled' => true,
                'max_size' => config('upload.max_file_size', '10MB'),
                'allowed_types' => config('upload.allowed_types', ['jpg', 'png', 'pdf'])
            ]
        ];
    }
}