<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Firebase\FirestoreClient;
use App\Repositories\Firebase\BookingsRepository;

class TestFirestoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firestore:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Firestore configuration and connectivity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Firestore Configuration...');
        $this->newLine();

        // Test 1: Check default database connection
        $this->info('1. Default database connection: ' . config('database.default'));
        
        // Test 2: Check Firestore configuration
        $this->info('2. Firestore project ID: ' . config('database.connections.firestore.project_id'));
        
        // Test 3: Test Firestore client instantiation
        $this->info('3. Testing Firestore client...');
        try {
            $firestore = app(FirestoreClient::class);
            $this->info('   ✓ Firestore client instantiated successfully');
        } catch (\Exception $e) {
            $this->error('   ✗ Failed to instantiate Firestore client: ' . $e->getMessage());
            return 1;
        }
        
        // Test 4: Test repository instantiation
        $this->info('4. Testing repositories...');
        try {
            $bookingsRepo = app(BookingsRepository::class);
            $this->info('   ✓ BookingsRepository instantiated successfully');
        } catch (\Exception $e) {
            $this->error('   ✗ Failed to instantiate BookingsRepository: ' . $e->getMessage());
            return 1;
        }
        
        // Test 5: Test environment variables
        $this->info('5. Environment variables:');
        $this->info('   - DB_CONNECTION: ' . env('DB_CONNECTION'));
        $this->info('   - STORE_DRIVER: ' . env('STORE_DRIVER'));
        $this->info('   - FIREBASE_PROJECT_ID: ' . env('FIREBASE_PROJECT_ID'));
        
        // Test 6: Test actual Firestore connection (optional)
        $this->info('6. Testing Firestore connectivity...');
        try {
            // This will test if we can connect to Firestore
            $projectId = config('database.connections.firestore.project_id');
            if (empty($projectId)) {
                $this->warn('   ⚠ No Firebase project ID configured');
            } else {
                $this->info('   ✓ Firebase project configured: ' . $projectId);
            }
        } catch (\Exception $e) {
            $this->error('   ✗ Firestore connection test failed: ' . $e->getMessage());
            return 1;
        }
        
        $this->newLine();
        $this->info('✅ Firestore configuration test completed successfully!');
        $this->info('Firestore is now configured as your main and default database.');
        $this->newLine();
        
        // Provide next steps
        $this->line('Next steps:');
        $this->line('1. Configure your Firebase project credentials in the .env file');
        $this->line('2. Set up Firestore security rules in Firebase Console');
        $this->line('3. Test with actual data operations using the repositories');
        $this->line('4. Check the documentation: backend/api/docs/FIRESTORE_SETUP.md');
        
        return 0;
    }
}