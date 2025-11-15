# HausTap API Testing Guide

## Server Information
- **Base URL**: http://localhost:8000
- **API Documentation**: http://localhost:8000/api/docs

## Authentication Flow

### 1. Register a New User
```bash
curl -X POST http://localhost:8000/api/v2/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1234567890",
    "role": "client"
  }'
```

### 2. Login User
```bash
curl -X POST http://localhost:8000/api/v2/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Test User",
      "email": "test@example.com",
      "role": "client"
    },
    "token": "YOUR_AUTH_TOKEN_HERE",
    "token_type": "Bearer"
  }
}
```

## API Endpoints Testing

### Authentication APIs

#### Get User Profile
```bash
curl -X GET http://localhost:8000/api/v2/auth/profile \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE"
```

#### Update Profile
```bash
curl -X POST http://localhost:8000/api/v2/auth/profile \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Name",
    "phone": "+0987654321"
  }'
```

#### Logout
```bash
curl -X POST http://localhost:8000/api/v2/auth/logout \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE"
```

### Notification APIs

#### Get Notifications
```bash
curl -X GET "http://localhost:8000/api/v2/notifications?per_page=10&category=booking" \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE"
```

#### Create Notification
```bash
curl -X POST http://localhost:8000/api/v2/notifications \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "title": "New Booking",
    "message": "You have a new booking request",
    "type": "info",
    "category": "booking",
    "related_id": "booking_123",
    "related_type": "booking"
  }'
```

#### Mark Notification as Read
```bash
curl -X PUT http://localhost:8000/api/v2/notifications/1/read \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE"
```

#### Get Unread Count
```bash
curl -X GET http://localhost:8000/api/v2/notifications/unread/count \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE"
```

### Location Pin APIs

#### Create Location Pin
```bash
curl -X POST http://localhost:8000/api/v2/location-pins \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Home",
    "description": "My home location",
    "latitude": 14.5995,
    "longitude": 120.9842,
    "address": "123 Main St",
    "city": "Manila",
    "country": "Philippines",
    "type": "home",
    "is_public": false
  }'
```

#### Get Location Pins
```bash
curl -X GET "http://localhost:8000/api/v2/location-pins?type=home" \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE"
```

#### Find Nearby Pins
```bash
curl -X POST http://localhost:8000/api/v2/location-pins/nearby \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "latitude": 14.5995,
    "longitude": 120.9842,
    "radius": 10
  }'
```

#### Geocode Address
```bash
curl -X POST http://localhost:8000/api/v2/location-pins/geocode \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "address": "Manila, Philippines"
  }'
```

#### Reverse Geocode
```bash
curl -X POST http://localhost:8000/api/v2/location-pins/reverse-geocode \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "latitude": 14.5995,
    "longitude": 120.9842
  }'
```

## Database Configuration

### MySQL Docker Setup
- **Host**: 127.0.0.1
- **Port**: 3307
- **Database**: haustap_db
- **Username**: haustap_user
- **Password**: haustap_password

### Firebase Integration
All data is synchronized between MySQL and Firebase Firestore for real-time capabilities.

## Architecture Features

1. **MVC Pattern**: Maintained throughout the application
2. **Dual Database**: MySQL for primary storage, Firebase for real-time sync
3. **RESTful APIs**: Standard HTTP methods and status codes
4. **Authentication**: Laravel Sanctum for API authentication
5. **Validation**: Comprehensive input validation
6. **Error Handling**: Consistent error response format

## Testing Commands Summary

```bash
# Test health endpoint
curl http://localhost:8000/api/health

# Test API documentation
curl http://localhost:8000/api/docs

# Test v2 API documentation
curl http://localhost:8000/api/v2/docs
```

## Live URL
The APIs are accessible at: **http://localhost:8000**

## Notes
- Replace `YOUR_AUTH_TOKEN_HERE` with the actual token received from login
- All timestamps are in ISO 8601 format
- Firebase synchronization happens automatically in the background
- Real-time notifications are available through Firebase listeners