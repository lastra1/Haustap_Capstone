<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SwitchDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:switch {driver : The database driver to switch to (firestore|mysql|sqlite)} {--force : Force the switch without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch between different database drivers (Firestore, MySQL, SQLite)';

    /**
     * Available database drivers
     */
    protected array $drivers = [
        'firestore' => [
            'name' => 'Firestore',
            'description' => 'Google Cloud Firestore (NoSQL)',
            'env_file' => '.env.firestore',
            'features' => ['Cloud-based', 'Real-time sync', 'Auto-scaling', 'Global distribution']
        ],
        'mysql' => [
            'name' => 'MySQL',
            'description' => 'Traditional relational database',
            'env_file' => '.env.mysql',
            'features' => ['Relational data', 'ACID transactions', 'Complex queries', 'Full-text search']
        ],
        'sqlite' => [
            'name' => 'SQLite',
            'description' => 'Lightweight file-based database',
            'env_file' => '.env.sqlite',
            'features' => ['Zero configuration', 'Serverless', 'Portable', 'Development friendly']
        ]
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $driver = strtolower($this->argument('driver'));
        $force = $this->option('force');

        // Validate driver
        if (!isset($this->drivers[$driver])) {
            $this->error("❌ Invalid database driver: {$driver}");
            $this->info("Available drivers: " . implode(', ', array_keys($this->drivers)));
            return 1;
        }

        $driverInfo = $this->drivers[$driver];
        
        // Show current configuration
        $this->info('📊 Current Database Configuration');
        $this->table(
            ['Setting', 'Current Value'],
            [
                ['DB_CONNECTION', config('database.default')],
                ['STORE_DRIVER', env('STORE_DRIVER', 'file')],
                ['FIREBASE_PROJECT_ID', env('FIREBASE_PROJECT_ID', 'Not set')],
                ['DB_DATABASE', env('DB_DATABASE', 'Not set')],
            ]
        );

        $this->newLine();
        
        // Show target driver information
        $this->info("🎯 Switching to: {$driverInfo['name']}");
        $this->line("Description: {$driverInfo['description']}");
        $this->line("Features: " . implode(', ', $driverInfo['features']));
        
        $this->newLine();

        // Confirmation (unless forced)
        if (!$force) {
            if (!$this->confirm("Are you sure you want to switch to {$driverInfo['name']}?")) {
                $this->info('❌ Database switch cancelled.');
                return 0;
            }
        }

        // Create backup of current .env
        $this->createBackup();

        // Switch database
        $result = $this->switchToDriver($driver, $driverInfo);

        if ($result) {
            $this->newLine();
            $this->info("✅ Successfully switched to {$driverInfo['name']}!");
            $this->postSwitchInstructions($driver);
        } else {
            $this->error("❌ Failed to switch to {$driverInfo['name']}");
            return 1;
        }

        return 0;
    }

    /**
     * Create backup of current .env file
     */
    protected function createBackup(): void
    {
        $envPath = base_path('.env');
        $backupPath = base_path('.env.backup.' . date('Y-m-d-His'));
        
        if (File::exists($envPath)) {
            File::copy($envPath, $backupPath);
            $this->info("📋 Created backup: " . basename($backupPath));
        }
    }

    /**
     * Switch to the specified driver
     */
    protected function switchToDriver(string $driver, array $driverInfo): bool
    {
        try {
            $sourceEnv = base_path($driverInfo['env_file']);
            $targetEnv = base_path('.env');

            // Check if source environment file exists
            if (!File::exists($sourceEnv)) {
                $this->warn("⚠️  Environment file not found: {$driverInfo['env_file']}");
                $this->info("Creating default configuration...");
                $this->createDefaultEnvFile($driver);
            }

            // Copy environment file
            File::copy($sourceEnv, $targetEnv);
            
            // Clear configuration cache
            $this->call('config:clear');
            $this->call('cache:clear');
            
            return true;
        } catch (\Exception $e) {
            $this->error("Error switching database: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create default environment file for driver
     */
    protected function createDefaultEnvFile(string $driver): void
    {
        $content = $this->getDefaultEnvContent($driver);
        $filePath = base_path(".env.{$driver}");
        
        File::put($filePath, $content);
        $this->info("✅ Created default environment file: .env.{$driver}");
    }

    /**
     * Get default environment content for driver
     */
    protected function getDefaultEnvContent(string $driver): string
    {
        $baseContent = $this->getBaseEnvContent();
        
        switch ($driver) {
            case 'firestore':
                return $baseContent . $this->getFirestoreConfig();
            case 'mysql':
                return $baseContent . $this->getMysqlConfig();
            case 'sqlite':
                return $baseContent . $this->getSqliteConfig();
            default:
                return $baseContent;
        }
    }

    /**
     * Get base environment content
     */
    protected function getBaseEnvContent(): string
    {
        return <<<'ENV'
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=file

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

ENV;
    }

    /**
     * Get Firestore configuration
     */
    protected function getFirestoreConfig(): string
    {
        return <<<'ENV'
# Database Configuration - Firestore as Primary
DB_CONNECTION=firestore
DB_DATABASE=haustap-booking-system

# Firebase Configuration
FIREBASE_PROJECT_ID=haustap-booking-system
FIREBASE_API_KEY=your-firebase-api-key
FIREBASE_AUTH_DOMAIN=haustap-booking-system.firebaseapp.com
FIREBASE_APP_ID=your-firebase-app-id
FIREBASE_STORAGE_BUCKET=haustap-booking-system.appspot.com
FIREBASE_MESSAGING_SENDER_ID=your-sender-id
FIREBASE_MEASUREMENT_ID=your-measurement-id

# Store Driver Configuration - Use Firestore
STORE_DRIVER=firestore

ENV;
    }

    /**
     * Get MySQL configuration
     */
    protected function getMysqlConfig(): string
    {
        return <<<'ENV'
# Database Configuration - MySQL as Primary
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=haustap
DB_USERNAME=root
DB_PASSWORD=

# Firebase Configuration (Optional - for hybrid mode)
FIREBASE_PROJECT_ID=haustap-booking-system
FIREBASE_API_KEY=your-firebase-api-key
FIREBASE_AUTH_DOMAIN=haustap-booking-system.firebaseapp.com
FIREBASE_APP_ID=your-firebase-app-id
FIREBASE_STORAGE_BUCKET=haustap-booking-system.appspot.com
FIREBASE_MESSAGING_SENDER_ID=your-sender-id
FIREBASE_MEASUREMENT_ID=your-measurement-id

# Store Driver Configuration - Use MySQL
STORE_DRIVER=mysql

ENV;
    }

    /**
     * Get SQLite configuration
     */
    protected function getSqliteConfig(): string
    {
        return <<<'ENV'
# Database Configuration - SQLite as Primary
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Firebase Configuration (Optional - for hybrid mode)
FIREBASE_PROJECT_ID=haustap-booking-system
FIREBASE_API_KEY=your-firebase-api-key
FIREBASE_AUTH_DOMAIN=haustap-booking-system.firebaseapp.com
FIREBASE_APP_ID=your-firebase-app-id
FIREBASE_STORAGE_BUCKET=haustap-booking-system.appspot.com
FIREBASE_MESSAGING_SENDER_ID=your-sender-id
FIREBASE_MEASUREMENT_ID=your-measurement-id

# Store Driver Configuration - Use File (default)
STORE_DRIVER=file

ENV;
    }

    /**
     * Show post-switch instructions
     */
    protected function postSwitchInstructions(string $driver): void
    {
        $this->newLine();
        $this->info('📋 Post-switch instructions:');
        
        switch ($driver) {
            case 'firestore':
                $this->firestoreInstructions();
                break;
            case 'mysql':
                $this->mysqlInstructions();
                break;
            case 'sqlite':
                $this->sqliteInstructions();
                break;
        }
        
        $this->newLine();
        $this->line('💡 You can switch back using: php artisan db:switch [driver]');
        $this->line('📖 See documentation: backend/api/docs/DATABASE_SWITCHING.md');
    }

    /**
     * Firestore specific instructions
     */
    protected function firestoreInstructions(): void
    {
        $this->line('1. Configure Firebase credentials in .env file');
        $this->line('2. Set up Firestore security rules in Firebase Console');
        $this->line('3. Test with: php artisan firestore:test');
        $this->line('4. Check documentation: backend/api/docs/FIRESTORE_SETUP.md');
    }

    /**
     * MySQL specific instructions
     */
    protected function mysqlInstructions(): void
    {
        $this->line('1. Ensure MySQL server is running');
        $this->line('2. Create database: CREATE DATABASE haustap;');
        $this->line('3. Run migrations: php artisan migrate');
        $this->line('4. Configure database credentials in .env if needed');
        $this->line('5. Test connection: php artisan db:monitor');
    }

    /**
     * SQLite specific instructions
     */
    protected function sqliteInstructions(): void
    {
        $this->line('1. Ensure database/database.sqlite exists');
        $this->line('2. Run migrations: php artisan migrate');
        $this->line('3. No additional configuration needed');
        $this->line('4. Test with: php artisan db:monitor');
    }
}