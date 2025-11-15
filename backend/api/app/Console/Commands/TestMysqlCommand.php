<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestMysqlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test MySQL database connection and configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Testing MySQL Database Configuration');
        $this->newLine();

        // Check current configuration
        $this->info('📊 Current Configuration:');
        $this->table(
            ['Setting', 'Value'],
            [
                ['DB_CONNECTION', config('database.default')],
                ['DB_HOST', env('DB_HOST', 'Not set')],
                ['DB_PORT', env('DB_PORT', 'Not set')],
                ['DB_DATABASE', env('DB_DATABASE', 'Not set')],
                ['DB_USERNAME', env('DB_USERNAME', 'Not set')],
                ['STORE_DRIVER', env('STORE_DRIVER', 'Not set')],
            ]
        );

        $this->newLine();

        // Test connection
        $this->info('🔗 Testing Database Connection...');
        try {
            $pdo = DB::connection()->getPdo();
            $this->info('✅ Database connection successful!');
            
            // Get connection details
            $this->info('📋 Connection Details:');
            $this->line('  Driver: ' . $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME));
            $this->line('  Server Version: ' . $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION));
            $this->line('  Client Version: ' . $pdo->getAttribute(\PDO::ATTR_CLIENT_VERSION));
            
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->warn('🔧 Troubleshooting Tips:');
            $this->line('1. Ensure MySQL server is running');
            $this->line('2. Check database credentials in .env file');
            $this->line('3. Verify database exists: CREATE DATABASE ' . env('DB_DATABASE', 'haustap'));
            $this->line('4. Check MySQL server logs');
            $this->line('5. Test connection manually: mysql -u ' . env('DB_USERNAME', 'root') . ' -p');
            return 1;
        }

        $this->newLine();

        // Test basic operations
        $this->info('🧪 Testing Basic Operations...');
        try {
            // Test query
            $result = DB::select('SELECT 1 as test');
            $this->info('✅ Query execution successful');
            
            // Test migrations table
            if (DB::select("SHOW TABLES LIKE 'migrations'")) {
                $this->info('✅ Migrations table exists');
                $count = DB::table('migrations')->count();
                $this->info("✅ Migrations count: {$count}");
            } else {
                $this->warn('⚠️  Migrations table not found');
                $this->line('  Run: php artisan migrate');
            }
            
            // Test json_store table (if using MySQL store driver)
            if (env('STORE_DRIVER') === 'mysql') {
                if (DB::select("SHOW TABLES LIKE 'json_store'")) {
                    $this->info('✅ JSON store table exists');
                } else {
                    $this->warn('⚠️  JSON store table not found');
                    $this->line('  Run: php artisan migrate');
                }
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Basic operations test failed');
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        $this->newLine();
        $this->info('🎉 MySQL configuration test completed successfully!');
        $this->info('Your MySQL database is ready to use.');
        
        return 0;
    }
}