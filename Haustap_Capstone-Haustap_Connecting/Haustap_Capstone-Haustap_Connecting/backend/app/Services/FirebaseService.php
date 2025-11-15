<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Firestore;
use Kreait\Firebase\Storage;
use Google\Cloud\Firestore\FirestoreClient;

class FirebaseService
{
    private $auth;
    private $firestore;
    private $storage;
    private $projectId;

    public function __construct()
    {
        $this->projectId = env('FIREBASE_PROJECT_ID');
        
        // Initialize Firebase
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS_PATH')))
            ->withProjectId($this->projectId);

        $this->auth = $factory->createAuth();
        $this->storage = $factory->createStorage();
        
        // Initialize Firestore
        $this->firestore = new FirestoreClient([
            'projectId' => $this->projectId,
            'keyFilePath' => base_path(env('FIREBASE_CREDENTIALS_PATH'))
        ]);
    }

    // Authentication Methods
    public function createUser($email, $password, $userData = [])
    {
        try {
            $userProperties = [
                'email' => $email,
                'password' => $password,
                'displayName' => $userData['displayName'] ?? '',
            ];

            $createdUser = $this->auth->createUser($userProperties);
            
            // Store additional user data in Firestore
            $this->firestore->collection('users')->document($createdUser->uid)->set([
                'uid' => $createdUser->uid,
                'email' => $email,
                'displayName' => $userData['displayName'] ?? '',
                'phoneNumber' => $userData['phoneNumber'] ?? '',
                'role' => $userData['role'] ?? 'client',
                'createdAt' => new \DateTime(),
                'updatedAt' => new \DateTime(),
                'isActive' => true
            ]);

            return $createdUser;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create user: ' . $e->getMessage());
        }
    }

    public function loginUser($email, $password)
    {
        try {
            // This would typically be done client-side, but for server-side validation
            $user = $this->auth->getUserByEmail($email);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception('Login failed: ' . $e->getMessage());
        }
    }

    public function getUserData($uid)
    {
        try {
            $userDoc = $this->firestore->collection('users')->document($uid)->snapshot();
            if ($userDoc->exists()) {
                return $userDoc->data();
            }
            return null;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get user data: ' . $e->getMessage());
        }
    }

    public function updateUserProfile($uid, $updates)
    {
        try {
            $updates['updatedAt'] = new \DateTime();
            $this->firestore->collection('users')->document($uid)->update($updates);
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Failed to update user profile: ' . $e->getMessage());
        }
    }

    // Booking Methods
    public function createBooking($bookingData)
    {
        try {
            $bookingRef = $this->firestore->collection('bookings')->newDocument();
            $bookingData['id'] = $bookingRef->id();
            $bookingData['createdAt'] = new \DateTime();
            $bookingData['updatedAt'] = new \DateTime();
            
            $bookingRef->set($bookingData);
            
            // Create initial status
            $this->updateBookingStatus($bookingRef->id(), 'pending', 'Booking created');
            
            return $bookingRef->id();
        } catch (\Exception $e) {
            throw new \Exception('Failed to create booking: ' . $e->getMessage());
        }
    }

    public function getBooking($bookingId)
    {
        try {
            $bookingDoc = $this->firestore->collection('bookings')->document($bookingId)->snapshot();
            if ($bookingDoc->exists()) {
                return $bookingDoc->data();
            }
            return null;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get booking: ' . $e->getMessage());
        }
    }

    public function getUserBookings($userId, $role = 'client')
    {
        try {
            $field = $role === 'client' ? 'clientId' : 'serviceProviderId';
            $query = $this->firestore->collection('bookings')
                ->where($field, '=', $userId)
                ->orderBy('createdAt', 'DESC');
            
            $bookings = [];
            foreach ($query->documents() as $document) {
                $bookings[] = $document->data();
            }
            
            return $bookings;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get user bookings: ' . $e->getMessage());
        }
    }

    public function updateBookingStatus($bookingId, $status, $notes = null)
    {
        try {
            $bookingRef = $this->firestore->collection('bookings')->document($bookingId);
            $bookingRef->update([
                'status' => $status,
                'updatedAt' => new \DateTime()
            ]);

            // Add to status history
            $statusRef = $this->firestore->collection('bookings')
                ->document($bookingId)
                ->collection('status_history')
                ->newDocument();
            
            $statusData = [
                'status' => $status,
                'timestamp' => new \DateTime(),
                'notes' => $notes ?: ''
            ];
            
            $statusRef->set($statusData);
            
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Failed to update booking status: ' . $e->getMessage());
        }
    }

    // Service Provider Methods
    public function getAvailableServiceProviders($serviceType)
    {
        try {
            $query = $this->firestore->collection('service_providers')
                ->where('services', 'array_contains', $serviceType)
                ->where('availability', '=', true)
                ->where('isActive', '=', true);
            
            $providers = [];
            foreach ($query->documents() as $document) {
                $providers[] = $document->data();
            }
            
            return $providers;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get service providers: ' . $e->getMessage());
        }
    }

    // Voucher Methods
    public function getValidVouchers($userId = null)
    {
        try {
            $now = new \DateTime();
            $query = $this->firestore->collection('vouchers')
                ->where('isActive', '=', true)
                ->where('expiryDate', '>', $now)
                ->where('usageLimit', '>', 0);
            
            $vouchers = [];
            foreach ($query->documents() as $document) {
                $voucher = $document->data();
                
                // Check if user has already used this voucher
                if ($userId) {
                    $usageDoc = $this->firestore->collection('voucher_usage')
                        ->document($userId . '_' . $document->id())
                        ->snapshot();
                    
                    if (!$usageDoc->exists() && $voucher['usedCount'] < $voucher['usageLimit']) {
                        $vouchers[] = $voucher;
                    }
                } else {
                    if ($voucher['usedCount'] < $voucher['usageLimit']) {
                        $vouchers[] = $voucher;
                    }
                }
            }
            
            return $vouchers;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get valid vouchers: ' . $e->getMessage());
        }
    }

    public function validateVoucher($code, $userId = null)
    {
        try {
            $query = $this->firestore->collection('vouchers')
                ->where('code', '=', strtoupper($code))
                ->where('isActive', '=', true);
            
            $vouchers = [];
            foreach ($query->documents() as $document) {
                $vouchers[] = $document->data();
            }
            
            if (empty($vouchers)) {
                return null;
            }
            
            $voucher = $vouchers[0];
            
            // Check if voucher is expired
            if ($voucher['expiryDate'] < new \DateTime()) {
                return null;
            }
            
            // Check if usage limit is reached
            if ($voucher['usedCount'] >= $voucher['usageLimit']) {
                return null;
            }
            
            // Check if user has already used this voucher
            if ($userId) {
                $usageDoc = $this->firestore->collection('voucher_usage')
                    ->document($userId . '_' . $voucher['id'])
                    ->snapshot();
                
                if ($usageDoc->exists()) {
                    return null;
                }
            }
            
            return $voucher;
        } catch (\Exception $e) {
            throw new \Exception('Failed to validate voucher: ' . $e->getMessage());
        }
    }

    // File Upload Methods
    public function uploadFile($file, $path)
    {
        try {
            $bucket = $this->storage->getBucket();
            $object = $bucket->upload(fopen($file['tmp_name'], 'r'), [
                'name' => $path,
                'metadata' => [
                    'contentType' => $file['type']
                ]
            ]);
            
            return $object->signedUrl(new \DateTime('+1 year'));
        } catch (\Exception $e) {
            throw new \Exception('Failed to upload file: ' . $e->getMessage());
        }
    }

    public function deleteFile($path)
    {
        try {
            $bucket = $this->storage->getBucket();
            $object = $bucket->object($path);
            $object->delete();
            
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Failed to delete file: ' . $e->getMessage());
        }
    }

    // Dashboard Statistics
    public function getDashboardStats()
    {
        try {
            $bookings = $this->firestore->collection('bookings')->documents();
            $users = $this->firestore->collection('users')->documents();
            $providers = $this->firestore->collection('service_providers')->documents();
            
            $totalBookings = 0;
            $pendingBookings = 0;
            $completedBookings = 0;
            
            foreach ($bookings as $document) {
                $booking = $document->data();
                $totalBookings++;
                
                if ($booking['status'] === 'pending') {
                    $pendingBookings++;
                } elseif ($booking['status'] === 'completed') {
                    $completedBookings++;
                }
            }
            
            return [
                'totalBookings' => $totalBookings,
                'pendingBookings' => $pendingBookings,
                'completedBookings' => $completedBookings,
                'totalUsers' => count(iterator_to_array($users)),
                'totalServiceProviders' => count(iterator_to_array($providers))
            ];
        } catch (\Exception $e) {
            throw new \Exception('Failed to get dashboard stats: ' . $e->getMessage());
        }
    }
}