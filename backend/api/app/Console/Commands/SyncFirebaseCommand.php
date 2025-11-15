<?php

namespace App\Console\Commands;

use App\Services\MySQLFirebaseBridgeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncFirebaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:firebase 
                            {--direction=both : Sync direction (to-firebase, from-firebase, both)}
                            {--type=all : Sync type (users, bookings, all)}
                            {--force : Force sync even if data exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize data between MySQL and Firebase Firestore';

    private MySQLFirebaseBridgeService $bridgeService;

    public function __construct(MySQLFirebaseBridgeService $bridgeService)
    {
        parent::__construct();
        $this->bridgeService = $bridgeService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting MySQL-Firebase synchronization...');
        
        $direction = $this->option('direction');
        $type = $this->option('type');
        $force = $this->option('force');

        try {
            $startTime = microtime(true);

            // Show current status
            $this->showStatus();

            if ($direction === 'to-firebase' || $direction === 'both') {
                if ($type === 'users' || $type === 'all') {
                    $this->syncUsersToFirebase();
                }
                
                if ($type === 'bookings' || $type === 'all') {
                    $this->syncBookingsToFirebase();
                }
            }

            if ($direction === 'from-firebase' || $direction === 'both') {
                if ($type === 'users' || $type === 'all') {
                    $this->syncUsersFromFirebase();
                }
                
                if ($type === 'bookings' || $type === 'all') {
                    $this->syncBookingsFromFirebase();
                }
            }

            $endTime = microtime(true);
            $duration = round($endTime - $startTime, 2);

            $this->info("✅ Synchronization completed in {$duration} seconds");
            
            // Show final status
            $this->showStatus();

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Synchronization failed: " . $e->getMessage());
            Log::error('Firebase sync command failed', ['error' => $e->getMessage()]);
            return Command::FAILURE;
        }
    }

    private function showStatus(): void
    {
        $this->info('📊 Current Sync Status:');
        $status = $this->bridgeService->getSyncStatus();
        
        $this->table(
            ['Metric', 'Value'],
            [
                ['MySQL Users', $status['mysql_users']],
                ['MySQL Bookings', $status['mysql_bookings']],
                ['Users with Firebase ID', $status['users_with_firebase_id']],
                ['Unsynced Bookings', $status['unsynced_bookings']],
                ['Last User Sync', $status['last_sync']['users'] ?? 'Never'],
                ['Last Booking Sync', $status['last_sync']['bookings'] ?? 'Never'],
            ]
        );
    }

    private function syncUsersToFirebase(): void
    {
        $this->info('🔄 Syncing users to Firebase...');
        $result = $this->bridgeService->syncUsersToFirebase();
        
        if ($result['synced'] > 0) {
            $this->info("✅ {$result['synced']} users synced to Firebase");
        } else {
            $this->warn('⚠️ No users synced to Firebase');
        }
        
        if (!empty($result['errors'])) {
            $this->error('❌ Errors encountered:');
            foreach ($result['errors'] as $error) {
                $this->error("  - {$error}");
            }
        }
    }

    private function syncUsersFromFirebase(): void
    {
        $this->info('🔄 Syncing users from Firebase...');
        $result = $this->bridgeService->syncUsersFromFirebase();
        
        if ($result['synced'] > 0) {
            $this->info("✅ {$result['synced']} users synced from Firebase");
        } else {
            $this->warn('⚠️ No users synced from Firebase');
        }
        
        if (!empty($result['errors'])) {
            $this->error('❌ Errors encountered:');
            foreach ($result['errors'] as $error) {
                $this->error("  - {$error}");
            }
        }
    }

    private function syncBookingsToFirebase(): void
    {
        $this->info('🔄 Syncing bookings to Firebase...');
        $result = $this->bridgeService->syncBookings();
        
        if ($result['mysql_to_firebase'] > 0) {
            $this->info("✅ {$result['mysql_to_firebase']} bookings synced to Firebase");
        } else {
            $this->warn('⚠️ No bookings synced to Firebase');
        }
        
        if (!empty($result['errors'])) {
            $this->error('❌ Errors encountered:');
            foreach ($result['errors'] as $error) {
                $this->error("  - {$error}");
            }
        }
    }

    private function syncBookingsFromFirebase(): void
    {
        $this->info('🔄 Syncing bookings from Firebase...');
        // This method would be implemented if needed
        $this->warn('⚠️ Syncing bookings from Firebase is not implemented yet');
    }
}