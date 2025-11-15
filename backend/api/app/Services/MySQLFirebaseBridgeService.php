<?php
namespace App\Services;

use App\Models\User;
use App\Models\Booking;
use App\Models\Notification;
use App\Repositories\Firebase\UsersRepository;
use App\Repositories\Firebase\BookingsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MySQLFirebaseBridgeService
{
    private UsersRepository $firebaseUsers;
    private BookingsRepository $firebaseBookings;

    public function __construct(
        UsersRepository $firebaseUsers,
        BookingsRepository $firebaseBookings
    ) {
        $this->firebaseUsers = $firebaseUsers;
        $this->firebaseBookings = $firebaseBookings;
    }

    /**
     * Sync MySQL users to Firebase Firestore
     */
    public function syncUsersToFirebase(): array
    {
        $results = ['synced' => 0, 'errors' => []];
        
        try {
            DB::beginTransaction();
            
            $users = User::all();
            
            foreach ($users as $user) {
                try {
                    $firebaseData = [
                        'email' => $user->email,
                        'name' => $user->name,
                        'role' => $user->role ?? 'client',
                        'roles' => [$user->role ?? 'client'],
                        'mysql_id' => $user->id,
                        'synced_at' => now()->toIso8601String()
                    ];
                    
                    $firebaseId = $this->firebaseUsers->create($firebaseData, (string)$user->id);
                    
                    if ($firebaseId) {
                        $user->update(['firebase_id' => $firebaseId]);
                        $results['synced']++;
                    }
                } catch (\Exception $e) {
                    $results['errors'][] = "User {$user->id}: " . $e->getMessage();
                    Log::error('Firebase sync error for user ' . $user->id, ['error' => $e->getMessage()]);
                }
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $results['errors'][] = "Transaction error: " . $e->getMessage();
            Log::error('Firebase sync transaction error', ['error' => $e->getMessage()]);
        }
        
        return $results;
    }

    /**
     * Sync Firebase users to MySQL
     */
    public function syncUsersFromFirebase(): array
    {
        $results = ['synced' => 0, 'errors' => []];
        
        try {
            DB::beginTransaction();
            
            $firebaseUsers = $this->firebaseUsers->list();
            
            foreach ($firebaseUsers as $firebaseUser) {
                try {
                    $userData = [
                        'email' => $firebaseUser['email'] ?? '',
                        'name' => $firebaseUser['name'] ?? '',
                        'role' => $firebaseUser['role'] ?? 'client',
                        'firebase_id' => $firebaseUser['id'] ?? '',
                        'password' => bcrypt('temp_password_' . uniqid()),
                    ];
                    
                    User::updateOrCreate(
                        ['email' => $userData['email']],
                        $userData
                    );
                    
                    $results['synced']++;
                } catch (\Exception $e) {
                    $results['errors'][] = "Firebase user {$firebaseUser['id']}: " . $e->getMessage();
                    Log::error('MySQL sync error for Firebase user', ['error' => $e->getMessage()]);
                }
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $results['errors'][] = "Transaction error: " . $e->getMessage();
            Log::error('MySQL sync transaction error', ['error' => $e->getMessage()]);
        }
        
        return $results;
    }

    /**
     * Sync bookings between MySQL and Firebase
     */
    public function syncBookings(): array
    {
        $results = ['mysql_to_firebase' => 0, 'firebase_to_mysql' => 0, 'errors' => []];
        
        try {
            // Sync MySQL bookings to Firebase
            $mysqlBookings = Booking::whereNull('firebase_synced_at')
                ->orWhere('updated_at', '>', DB::raw('firebase_synced_at'))
                ->get();
            
            foreach ($mysqlBookings as $booking) {
                try {
                    $this->syncBookingToFirebase($booking);
                    $results['mysql_to_firebase']++;
                } catch (\Exception $e) {
                    $results['errors'][] = "Booking {$booking->id}: " . $e->getMessage();
                }
            }
            
            // Sync Firebase bookings to MySQL would go here if needed
            
        } catch (\Exception $e) {
            $results['errors'][] = "General error: " . $e->getMessage();
        }
        
        return $results;
    }

    /**
     * Sync a single booking to Firebase
     */
    private function syncBookingToFirebase(Booking $booking): void
    {
        $bookingData = [
            'user_id' => $booking->user_id,
            'service_id' => $booking->service_id,
            'provider_id' => $booking->provider_id,
            'booking_date' => $booking->booking_date->toIso8601String(),
            'status' => $booking->status,
            'total_amount' => $booking->total_amount,
            'notes' => $booking->notes,
            'synced_at' => now()->toIso8601String()
        ];
        
        $firebaseId = $this->firebaseBookings->create($bookingData, (string)$booking->id);
        
        if ($firebaseId) {
            $booking->update(['firebase_synced_at' => now()]);
        }
    }

    /**
     * Get sync status
     */
    public function getSyncStatus(): array
    {
        return [
            'mysql_users' => User::count(),
            'mysql_bookings' => Booking::count(),
            'unsynced_bookings' => Booking::whereNull('firebase_synced_at')->count(),
            'users_with_firebase_id' => User::whereNotNull('firebase_id')->count(),
            'last_sync' => [
                'users' => User::max('updated_at'),
                'bookings' => Booking::max('firebase_synced_at')
            ]
        ];
    }
}