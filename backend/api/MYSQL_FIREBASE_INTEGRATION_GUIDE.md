# MySQL-Firebase Integration Guide for HausTap Service Booking Platform

## Overview

This guide provides comprehensive instructions for connecting your MySQL database with Firebase APIs using Docker and implementing bidirectional data synchronization for the HausTap Service Booking Platform.

## Architecture Overview

```
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│   MySQL DB      │◄──►│  Laravel API     │◄──►│  Firebase       │
│   (Local)       │    │  Bridge Service  │    │  Firestore      │
└─────────────────┘    └──────────────────┘    └─────────────────┘
       │                        │                       │
       ▼                        ▼                       ▼
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│  Docker         │    │  Sync Controller   │    │  Real-time      │
│  Container      │    │  Commands          │    │  Updates        │
└─────────────────┘    └──────────────────┘    └─────────────────┘
```

## Features

- ✅ **Bidirectional Sync**: MySQL ↔ Firebase data synchronization
- ✅ **Real-time Updates**: Automatic sync triggers
- ✅ **Conflict Resolution**: Handles data conflicts intelligently
- ✅ **Error Handling**: Comprehensive error logging and recovery
- ✅ **API Endpoints**: RESTful API for sync operations
- ✅ **Console Commands**: Artisan commands for manual sync
- ✅ **Status Monitoring**: Real-time sync status tracking
- ✅ **Docker Integration**: Containerized MySQL setup

## Quick Start

### 1. Prerequisites

- PHP 8.1+
- Composer
- MySQL 8.0+ (or Docker)
- Firebase Project with Firestore enabled
- Firebase Service Account credentials

### 2. Setup MySQL Database

#### Option A: Using Docker (Recommended)

```powershell
# Navigate to backend/api directory
cd backend/api

# Start MySQL container
docker-compose -f docker-compose-mysql-only.yml up -d

# Verify MySQL is running
docker exec haustap_mysql mysql -u haustap_user -phaustap_password -e "SELECT 'Connection successful!' as message;"
```

#### Option B: Local MySQL Installation

1. Install MySQL 8.0+ locally
2. Create database and user:

```sql
CREATE DATABASE haustap_db;
CREATE USER 'haustap_user'@'localhost' IDENTIFIED BY 'haustap_password';
GRANT ALL PRIVILEGES ON haustap_db.* TO 'haustap_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Configure Environment

```bash
# Copy environment file
cp .env.example .env

# Update database configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=haustap_db
DB_USERNAME=haustap_user
DB_PASSWORD=haustap_password

# Firebase configuration
FIREBASE_PROJECT_ID=haustap-booking-system
```

### 4. Install Dependencies

```bash
composer install
php artisan key:generate
```

### 5. Setup Firebase Credentials

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Project Settings → Service Accounts
3. Generate new private key
4. Save as `config/firebase-service-account.json`

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. Run Setup Script

#### Windows (PowerShell)
```powershell
.\setup-mysql-firebase.ps1
```

#### Linux/Mac (Bash)
```bash
chmod +x setup-mysql-firebase.sh
./setup-mysql-firebase.sh
```

## API Endpoints

### Sync Status
```http
GET /api/sync/status
```

Response:
```json
{
    "success": true,
    "data": {
        "mysql_users": 150,
        "mysql_bookings": 75,
        "unsynced_bookings": 5,
        "users_with_firebase_id": 145,
        "last_sync": {
            "users": "2024-01-15 10:30:00",
            "bookings": "2024-01-15 10:25:00"
        }
    }
}
```

### Sync Users to Firebase
```http
POST /api/sync/users/to-firebase
```

### Sync Users from Firebase
```http
POST /api/sync/users/from-firebase
```

### Sync Bookings
```http
POST /api/sync/bookings
```

### Full Sync
```http
POST /api/sync/full
```

## Console Commands

### Basic Sync Commands

```bash
# Full synchronization
php artisan sync:firebase

# Sync users to Firebase
php artisan sync:firebase --direction=to-firebase --type=users

# Sync bookings from Firebase
php artisan sync:firebase --direction=from-firebase --type=bookings

# Sync all data bidirectionally
php artisan sync:firebase --direction=both --type=all
```

### Advanced Options

```bash
# Force sync (ignore existing data)
php artisan sync:firebase --force

# Verbose output
php artisan sync:firebase -v

# Dry run (preview changes)
php artisan sync:firebase --pretend
```

## Database Schema

### Users Table (Enhanced)
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    firebase_id VARCHAR(255) UNIQUE,
    firebase_synced_at TIMESTAMP NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255),
    role VARCHAR(50) DEFAULT 'client',
    -- ... other fields
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_firebase_id (firebase_id),
    INDEX idx_firebase_synced_at (firebase_synced_at)
);
```

### Bookings Table (Enhanced)
```sql
CREATE TABLE bookings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    firebase_id VARCHAR(255) UNIQUE,
    firebase_synced_at TIMESTAMP NULL,
    user_id BIGINT NOT NULL,
    service_id BIGINT NOT NULL,
    provider_id BIGINT,
    booking_date DATETIME NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    total_amount DECIMAL(10,2),
    notes TEXT,
    -- ... other fields
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_firebase_id (firebase_id),
    INDEX idx_firebase_synced_at (firebase_synced_at),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status)
);
```

## Configuration

### Environment Variables

```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=haustap_db
DB_USERNAME=haustap_user
DB_PASSWORD=haustap_password

# Firebase Configuration
FIREBASE_PROJECT_ID=haustap-booking-system
FIREBASE_CREDENTIALS_PATH=/app/config/firebase-service-account.json

# Sync Configuration
SYNC_BATCH_SIZE=100
SYNC_RETRY_ATTEMPTS=3
SYNC_RETRY_DELAY=5
```

### Service Configuration

Create `config/firebase.php`:

```php
<?php

return [
    'project_id' => env('FIREBASE_PROJECT_ID'),
    'credentials_path' => env('FIREBASE_CREDENTIALS_PATH'),
    'sync' => [
        'batch_size' => env('SYNC_BATCH_SIZE', 100),
        'retry_attempts' => env('SYNC_RETRY_ATTEMPTS', 3),
        'retry_delay' => env('SYNC_RETRY_DELAY', 5),
    ],
];
```

## Monitoring and Logging

### Log Files

- **Laravel Logs**: `storage/logs/laravel.log`
- **Sync Logs**: `storage/logs/sync.log`
- **Error Logs**: `storage/logs/firebase-errors.log`

### Monitoring Commands

```bash
# Monitor sync logs in real-time
tail -f storage/logs/laravel.log | grep "sync"

# Check sync status
curl -X GET http://localhost:8000/api/sync/status

# View recent sync operations
php artisan tinker
>>> DB::table('users')->whereNotNull('firebase_synced_at')->count();
>>> DB::table('bookings')->whereNull('firebase_synced_at')->count();
```

### Health Checks

```bash
# Test MySQL connection
php artisan tinker
>>> DB::connection()->getPdo();

# Test Firebase connection
php artisan tinker
>>> $fs = app(\App\Services\Firebase\FirestoreClient::class);
>>> $fs->list('users', 1);
```

## Troubleshooting

### Common Issues

#### 1. MySQL Connection Failed
```bash
# Check MySQL service status
sudo systemctl status mysql

# Test connection manually
mysql -u haustap_user -phaustap_password -e "SELECT 1;"

# Check Docker container
docker ps | grep haustap_mysql
```

#### 2. Firebase Authentication Error
```bash
# Verify service account file exists
ls -la config/firebase-service-account.json

# Check file permissions
chmod 600 config/firebase-service-account.json

# Verify Firebase project ID
echo $FIREBASE_PROJECT_ID
```

#### 3. Sync Failures
```bash
# Check error logs
tail -f storage/logs/laravel.log

# Test individual components
php artisan sync:firebase --direction=to-firebase --type=users -v

# Clear caches
php artisan cache:clear
php artisan config:clear
```

#### 4. Docker Issues
```bash
# Check Docker status
docker system info

# Restart containers
docker-compose -f docker-compose-mysql-only.yml restart

# View container logs
docker logs haustap_mysql
```

### Performance Optimization

#### 1. Batch Processing
```php
// Configure batch size in .env
SYNC_BATCH_SIZE=500
```

#### 2. Index Optimization
```sql
-- Add indexes for better sync performance
CREATE INDEX idx_users_firebase_sync ON users(firebase_synced_at, updated_at);
CREATE INDEX idx_bookings_firebase_sync ON bookings(firebase_synced_at, updated_at);
```

#### 3. Queue Processing
```bash
# Use Laravel queues for large sync operations
php artisan queue:work --queue=sync
```

## Security Considerations

### 1. Database Security
- Use strong passwords for MySQL users
- Restrict database access to localhost only
- Enable SSL connections for production

### 2. Firebase Security
- Keep service account credentials secure
- Use Firebase Security Rules
- Implement proper authentication

### 3. API Security
- Use HTTPS in production
- Implement rate limiting
- Validate all input data
- Use API authentication

## Deployment

### Production Deployment

1. **Environment Setup**
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Use production database
DB_HOST=your-production-db-host
DB_PASSWORD=your-strong-password
```

2. **Database Migration**
```bash
php artisan migrate --force
```

3. **Queue Workers**
```bash
php artisan queue:work --queue=sync --sleep=3 --tries=3
```

4. **Scheduled Sync**
```bash
# Add to crontab
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### Docker Production Deployment

```yaml
# docker-compose.production.yml
version: '3.8'
services:
  mysql:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: haustap_production
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_USER: ${DB_USERNAME}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - mysql_production_data:/var/lib/mysql
    networks:
      - haustap_network

  app:
    build: .
    environment:
      APP_ENV: production
      DB_HOST: mysql
      FIREBASE_PROJECT_ID: ${FIREBASE_PROJECT_ID}
    depends_on:
      - mysql
    networks:
      - haustap_network

networks:
  haustap_network:
    driver: bridge

volumes:
  mysql_production_data:
```

## Support

For issues and questions:
1. Check the troubleshooting section above
2. Review logs in `storage/logs/`
3. Test individual components using provided commands
4. Contact development team with specific error messages

## API Testing Examples

### Using cURL
```bash
# Test sync status
curl -X GET http://localhost:8000/api/sync/status

# Sync users to Firebase
curl -X POST http://localhost:8000/api/sync/users/to-firebase \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_API_TOKEN"

# Full sync
curl -X POST http://localhost:8000/api/sync/full \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_API_TOKEN"
```

### Using Postman

1. Import the collection from `postman/HausTap.postman_collection.json`
2. Set up environment variables:
   - `base_url`: `http://localhost:8000`
   - `api_token`: Your authentication token
3. Test the sync endpoints in the "Sync" folder

---

**Note**: This integration provides a robust bridge between your MySQL database and Firebase Firestore, enabling real-time data synchronization and ensuring data consistency across both systems. Regular monitoring and maintenance of the sync processes are recommended for optimal performance.