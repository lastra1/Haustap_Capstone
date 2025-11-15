# Firebase Setup Guide for HausTap Application

## Overview
This guide will help you set up Firebase as your backend for both your React Native mobile app and PHP Laravel website, replacing your current Laravel backend.

## Prerequisites
- Firebase account (free tier available)
- Node.js and npm/pnpm installed
- PHP and Composer installed
- Expo CLI installed (for mobile app)

## Step 1: Create Firebase Project

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Click "Create Project" or "Add Project"
3. Enter project name: "HausTap"
4. Enable Google Analytics (optional)
5. Click "Create Project"

## Step 2: Enable Firebase Services

### Enable Authentication
1. Go to "Authentication" in Firebase Console
2. Click "Get Started"
3. Enable the following sign-in methods:
   - Email/Password
   - Google (optional)
   - Phone (optional)

### Enable Firestore Database
1. Go to "Firestore Database" in Firebase Console
2. Click "Create Database"
3. Choose "Start in test mode" (change to production mode later)
4. Select your region

### Enable Storage
1. Go to "Storage" in Firebase Console
2. Click "Get Started"
3. Choose "Start in test mode" (change to production mode later)

## Step 3: Get Firebase Configuration

1. Go to Project Settings (gear icon)
2. Under "Your apps" section, click "Add app"
3. Choose "Web" platform
4. Register app with nickname "HausTap-Web"
5. Copy the configuration object

Repeat for "Android" platform for your mobile app.

## Step 4: Mobile App Configuration

### 1. Update Environment Variables
Create a `.env` file in your mobile app root directory:

```env
EXPO_PUBLIC_FIREBASE_API_KEY=your-api-key
EXPO_PUBLIC_FIREBASE_AUTH_DOMAIN=your-auth-domain
EXPO_PUBLIC_FIREBASE_PROJECT_ID=your-project-id
EXPO_PUBLIC_FIREBASE_STORAGE_BUCKET=your-storage-bucket
EXPO_PUBLIC_FIREBASE_MESSAGING_SENDER_ID=your-messaging-sender-id
EXPO_PUBLIC_FIREBASE_APP_ID=your-app-id
```

### 2. Install Firebase Dependencies (Already done)
```bash
cd mobile_app/HausTap
npm install firebase @react-native-firebase/app @react-native-firebase/auth @react-native-firebase/firestore @react-native-firebase/storage
```

### 3. Update App Configuration
Update your `app.json` to include Firebase configuration:

```json
{
  "expo": {
    "plugins": [
      "@react-native-firebase/app",
      [
        "expo-build-properties",
        {
          "ios": {
            "useFrameworks": "static"
          }
        }
      ]
    ]
  }
}
```

## Step 5: Laravel Backend Configuration

### 1. Install Firebase PHP SDK
```bash
cd backend
composer require kreait/firebase-php google/cloud-firestore
```

### 2. Update Environment Variables
Add to your `.env` file:

```env
FIREBASE_PROJECT_ID=your-project-id
FIREBASE_CREDENTIALS_PATH=service-account.json
```

### 3. Create Service Account
1. Go to Firebase Console → Project Settings → Service Accounts
2. Click "Generate new private key"
3. Save the JSON file as `service-account.json` in your backend root directory

### 4. Update Routes
Add Firebase routes to `routes/web.php`:

```php
// Firebase Authentication Routes
Route::prefix('api/firebase')->group(function () {
    Route::post('/register', [FirebaseAuthController::class, 'register']);
    Route::post('/login', [FirebaseAuthController::class, 'login']);
    Route::get('/user/{uid}', [FirebaseAuthController::class, 'getUserProfile']);
    Route::put('/user/{uid}', [FirebaseAuthController::class, 'updateProfile']);
    Route::post('/reset-password', [FirebaseAuthController::class, 'resetPassword']);
});

// Firebase Booking Routes
Route::prefix('api/firebase/bookings')->group(function () {
    Route::post('/', [FirebaseBookingController::class, 'createBooking']);
    Route::get('/{bookingId}', [FirebaseBookingController::class, 'getBooking']);
    Route::get('/user/{userId}', [FirebaseBookingController::class, 'getUserBookings']);
    Route::put('/{bookingId}/status', [FirebaseBookingController::class, 'updateBookingStatus']);
    Route::put('/{bookingId}/assign-provider', [FirebaseBookingController::class, 'assignServiceProvider']);
    Route::put('/{bookingId}/cancel', [FirebaseBookingController::class, 'cancelBooking']);
    Route::get('/providers/available', [FirebaseBookingController::class, 'getAvailableServiceProviders']);
    Route::get('/stats/{userId}', [FirebaseBookingController::class, 'getBookingStats']);
});
```

## Step 6: Database Structure

### Firestore Collections Structure

#### users
```javascript
{
  uid: "string",
  email: "string",
  displayName: "string",
  phoneNumber: "string",
  role: "client|service_provider|admin",
  createdAt: timestamp,
  updatedAt: timestamp,
  isActive: boolean
}
```

#### service_providers
```javascript
{
  uid: "string",
  email: "string",
  displayName: "string",
  phoneNumber: "string",
  businessName: "string",
  services: ["string"],
  rating: number,
  totalBookings: number,
  availability: boolean,
  createdAt: timestamp,
  updatedAt: timestamp,
  isActive: boolean
}
```

#### bookings
```javascript
{
  id: "string",
  clientId: "string",
  serviceProviderId: "string",
  serviceType: "string",
  serviceDetails: object,
  location: {
    address: "string",
    latitude: number,
    longitude: number
  },
  schedule: {
    date: timestamp,
    time: "string"
  },
  status: "pending|confirmed|ongoing|completed|cancelled|returned",
  pricing: {
    basePrice: number,
    additionalCharges: number,
    discount: number,
    totalPrice: number
  },
  paymentStatus: "pending|paid|refunded",
  notes: "string",
  createdAt: timestamp,
  updatedAt: timestamp
}
```

#### vouchers
```javascript
{
  id: "string",
  code: "string",
  discountType: "percentage|fixed",
  discountValue: number,
  minOrderAmount: number,
  maxDiscount: number,
  expiryDate: timestamp,
  usageLimit: number,
  usedCount: number,
  isActive: boolean,
  createdAt: timestamp
}
```

## Step 7: Security Rules

### Firestore Security Rules
```javascript
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    // Users can only read/update their own data
    match /users/{userId} {
      allow read, update: if request.auth != null && request.auth.uid == userId;
      allow create: if request.auth != null;
    }
    
    // Service providers can only read/update their own data
    match /service_providers/{providerId} {
      allow read, update: if request.auth != null && request.auth.uid == providerId;
      allow create: if request.auth != null;
    }
    
    // Bookings - clients can read their own bookings, providers can read assigned bookings
    match /bookings/{bookingId} {
      allow read: if request.auth != null && 
        (resource.data.clientId == request.auth.uid || 
         resource.data.serviceProviderId == request.auth.uid);
      allow create: if request.auth != null && request.auth.uid == request.resource.data.clientId;
      allow update: if request.auth != null && 
        (resource.data.clientId == request.auth.uid || 
         resource.data.serviceProviderId == request.auth.uid);
    }
    
    // Vouchers are publicly readable
    match /vouchers/{voucherId} {
      allow read: if request.auth != null;
    }
    
    // Voucher usage
    match /voucher_usage/{usageId} {
      allow read, write: if request.auth != null && request.auth.uid == resource.data.userId;
    }
  }
}
```

## Step 8: Testing

### Test Mobile App
```bash
cd mobile_app/HausTap
npm start
```

### Test Laravel Backend
```bash
cd backend
php artisan serve
```

## Step 9: Migration from Laravel to Firebase

### Data Migration Script
Create a script to migrate your existing Laravel database to Firebase:

```php
<?php
// Create migration script in backend/scripts/migrate-to-firebase.php

use App\Services\FirebaseService;
use App\Models\User;
use App\Models\Booking;

$firebaseService = app(FirebaseService::class);

// Migrate users
$users = User::all();
foreach ($users as $user) {
    try {
        $firebaseService->createUser(
            $user->email,
            $user->password, // You'll need to handle password migration carefully
            [
                'displayName' => $user->name,
                'phoneNumber' => $user->phone,
                'role' => $user->role,
            ]
        );
    } catch (\Exception $e) {
        echo "Failed to migrate user: " . $user->email . " - " . $e->getMessage() . "\n";
    }
}

// Migrate bookings
$bookings = Booking::all();
foreach ($bookings as $booking) {
    try {
        $firebaseService->createBooking([
            'clientId' => $booking->user_id,
            'serviceProviderId' => $booking->provider_id,
            'serviceType' => $booking->service_type,
            'location' => [
                'address' => $booking->address,
                'latitude' => $booking->latitude,
                'longitude' => $booking->longitude,
            ],
            'schedule' => [
                'date' => $booking->schedule_date,
                'time' => $booking->schedule_time,
            ],
            'status' => $booking->status,
            'pricing' => [
                'basePrice' => $booking->base_price,
                'totalPrice' => $booking->total_price,
            ],
        ]);
    } catch (\Exception $e) {
        echo "Failed to migrate booking: " . $booking->id . " - " . $e->getMessage() . "\n";
    }
}

echo "Migration completed!\n";
```

## Step 10: Deployment

### Mobile App Deployment
1. Update your `app.json` with production Firebase configuration
2. Build for production:
```bash
expo build:android
expo build:ios
```

### Laravel Backend Deployment
1. Update production environment variables
2. Deploy to your hosting provider
3. Ensure service account JSON file is properly secured

## Troubleshooting

### Common Issues

1. **Permission Denied Errors**
   - Check Firestore security rules
   - Ensure proper authentication
   - Verify user roles

2. **CORS Issues**
   - Configure CORS in Laravel
   - Use proper Firebase configuration

3. **Authentication Issues**
   - Verify Firebase Auth configuration
   - Check user roles and permissions
   - Ensure proper token handling

### Support
- Firebase Documentation: https://firebase.google.com/docs
- React Native Firebase: https://rnfirebase.io/
- Laravel Firebase PHP: https://github.com/kreait/firebase-php

## Next Steps

1. Implement real-time notifications using Firebase Cloud Messaging
2. Add payment integration with Firebase Extensions
3. Implement analytics with Firebase Analytics
4. Add crash reporting with Firebase Crashlytics
5. Set up automated backups for Firestore data