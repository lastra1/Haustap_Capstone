# Firestore as Primary Database Configuration

This guide explains how Firestore has been configured as the main and default database for the HausTap application.

## Overview

Firestore is now configured as the primary database system for the Laravel backend, replacing the default SQLite/MySQL setup. This provides:

- **Cloud-based NoSQL database** with automatic scaling
- **Real-time data synchronization** across all clients
- **Offline support** with automatic sync when online
- **Built-in security rules** and authentication integration
- **Global distribution** with low latency

## Configuration Changes

### 1. Environment Variables (.env)

The following environment variables have been configured:

```env
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
```

### 2. Database Configuration (config/database.php)

Added Firestore connection configuration:

```php
'firestore' => [
    'driver' => 'firestore',
    'project_id' => env('FIREBASE_PROJECT_ID', 'haustap-booking-system'),
    'api_key' => env('FIREBASE_API_KEY'),
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
    'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
    'app_id' => env('FIREBASE_APP_ID'),
    'measurement_id' => env('FIREBASE_MEASUREMENT_ID'),
],
```

### 3. Service Provider (app/Providers/FirestoreServiceProvider.php)

Created a dedicated service provider that:
- Registers Firestore client as a singleton
- Registers all Firebase repositories
- Configures Firestore as the default database connection

### 4. File Store Integration (app/Support/FileJsonStore.php)

Enhanced the FileJsonStore class to support Firestore:
- Added Firestore as a storage driver option
- Implemented data conversion between PHP arrays and Firestore fields
- Maintains backward compatibility with file and MySQL storage

## Available Firebase Repositories

The following repositories are available for Firestore operations:

### 1. BookingsRepository
- **Location**: `app/Repositories/Firebase/BookingsRepository.php`
- **Collections**: `bookings`
- **Methods**: `list()`, `create()`, `setStatus()`, `cancel()`, `rate()`

### 2. UsersRepository
- **Location**: `app/Repositories/Firebase/UsersRepository.php`
- **Collections**: `users`
- **Methods**: User management operations

### 3. ProvidersRepository
- **Location**: `app/Repositories/Firebase/ProvidersRepository.php`
- **Collections**: `providers`
- **Methods**: Provider management operations

### 4. ServicesRepository
- **Location**: `app/Repositories/Firebase/ServicesRepository.php`
- **Collections**: `services`
- **Methods**: Service management operations

### 5. CategoriesRepository
- **Location**: `app/Repositories/Firebase/CategoriesRepository.php`
- **Collections**: `categories`
- **Methods**: Category management operations

### 6. ApplicantsRepository
- **Location**: `app/Repositories/Firebase/ApplicantsRepository.php`
- **Collections**: `applicants`
- **Methods**: Applicant management operations

## Usage Examples

### Using Firestore Repositories in Controllers

```php
use App\Repositories\Firebase\BookingsRepository;

class BookingController extends Controller
{
    private BookingsRepository $bookings;

    public function __construct(BookingsRepository $bookings)
    {
        $this->bookings = $bookings;
    }

    public function index()
    {
        $bookings = $this->bookings->list();
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $bookingId = $this->bookings->create([
            'provider_id' => $request->provider_id,
            'clientUid' => $request->client_uid,
            'service_name' => $request->service_name,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'address' => $request->address,
            'price' => $request->price,
        ]);

        return response()->json(['id' => $bookingId], 201);
    }
}
```

### Using Firestore Client Directly

```php
use App\Services\Firebase\FirestoreClient;

$firestore = app(FirestoreClient::class);

// List documents from a collection
$documents = $firestore->list('bookings', 50);

// Get a specific document
$document = $firestore->get('bookings', 'document-id');

// Create a new document
$newDoc = $firestore->create('bookings', [
    'field1' => ['stringValue' => 'value1'],
    'field2' => ['integerValue' => 123],
]);

// Update a document
$success = $firestore->patch('bookings', 'document-id', [
    'status' => ['stringValue' => 'completed']
]);
```

## Data Structure

Firestore documents use a specific field format. The repositories handle conversion automatically:

```php
// PHP array
$data = [
    'name' => 'John Doe',
    'age' => 30,
    'active' => true,
    'scores' => [85, 92, 78],
    'address' => [
        'street' => '123 Main St',
        'city' => 'New York'
    ]
];

// Converted to Firestore fields
$fields = [
    'name' => ['stringValue' => 'John Doe'],
    'age' => ['integerValue' => 30],
    'active' => ['booleanValue' => true],
    'scores' => ['arrayValue' => ['values' => [
        ['integerValue' => 85],
        ['integerValue' => 92],
        ['integerValue' => 78]
    ]]],
    'address' => ['mapValue' => ['fields' => [
        'street' => ['stringValue' => '123 Main St'],
        'city' => ['stringValue' => 'New York']
    ]]]
];
```

## Migration from SQLite/MySQL

### Step 1: Export Existing Data
```bash
# Export SQLite data
sqlite3 database/database.sqlite ".dump" > backup.sql

# Or export MySQL data
mysqldump -u username -p database_name > backup.sql
```

### Step 2: Import to Firestore
Use the Firebase Admin SDK or create a custom script to import data into Firestore collections.

### Step 3: Update Environment Variables
Change the following in your `.env` file:
```env
DB_CONNECTION=firestore
STORE_DRIVER=firestore
```

## Security Rules

Configure Firestore security rules in the Firebase Console:

```javascript
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    // Allow read access to all users
    match /{document=**} {
      allow read: if true;
    }
    
    // Require authentication for writes
    match /bookings/{booking} {
      allow create: if request.auth != null;
      allow update: if request.auth != null && 
        request.auth.uid == resource.data.clientUid;
    }
    
    match /users/{user} {
      allow write: if request.auth != null && 
        request.auth.uid == user;
    }
  }
}
```

## Monitoring and Debugging

### Enable Debug Logging
In your `.env` file:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Monitor Firestore Usage
- Use Firebase Console to monitor read/write operations
- Check Firestore quotas and billing
- Set up alerts for unusual activity

### Common Issues

1. **Permission Denied**: Check Firestore security rules
2. **Project Not Found**: Verify `FIREBASE_PROJECT_ID` in `.env`
3. **Authentication Errors**: Ensure Firebase service account has proper permissions

## Backup and Recovery

### Automated Backups
Set up automated exports using Firebase Admin SDK or Cloud Functions.

### Manual Export
Use Firebase Console to export collections:
1. Go to Firebase Console → Firestore
2. Select collection
3. Click "Export" button

### Disaster Recovery
Keep regular backups and test restore procedures to ensure data safety.

## Performance Optimization

### Indexing
Create composite indexes for complex queries in Firebase Console.

### Query Optimization
- Use pagination for large datasets
- Implement query cursors
- Cache frequently accessed data

### Connection Pooling
Firestore handles connection pooling automatically, but monitor usage patterns.

## Support and Resources

- **Firebase Documentation**: https://firebase.google.com/docs/firestore
- **Laravel Documentation**: https://laravel.com/docs
- **Project Issues**: Report issues in the project repository

## Next Steps

1. **Set up Firebase project** with proper security rules
2. **Configure authentication** integration
3. **Implement real-time features** using Firestore listeners
4. **Set up monitoring** and alerting
5. **Plan data migration** from existing databases