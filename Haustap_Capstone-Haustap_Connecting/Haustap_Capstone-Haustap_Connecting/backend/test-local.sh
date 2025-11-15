# Build and test Docker image locally
docker build -f Dockerfile.production -t haustap-laravel-api .

# Run with environment variables
docker run -d -p 8000:8000 \
  -e APP_KEY=base64:your-generated-key-here \
  -e DB_HOST=your-db-host \
  -e DB_DATABASE=haustap_db \
  -e DB_USERNAME=haustap_user \
  -e DB_PASSWORD=your-password \
  -e FIREBASE_PROJECT_ID=haustap-booking-system \
  -e REDIS_HOST=your-redis-host \
  --name haustap-api-test \
  haustap-laravel-api

# Test health endpoint
echo "Testing API health..."
curl -f http://localhost:8000/api/health || echo "Health check failed"

# Test Firebase endpoint
echo "Testing Firebase integration..."
curl -X POST http://localhost:8000/api/firebase/users/create \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123",
    "displayName": "Test User"
  }' || echo "Firebase test failed"

# Test booking endpoint
echo "Testing booking creation..."
curl -X POST http://localhost:8000/api/firebase/bookings/create \
  -H "Content-Type: application/json" \
  -d '{
    "clientId": "test-client",
    "serviceProviderId": "test-provider",
    "serviceType": "cleaning",
    "bookingDate": "2024-01-01",
    "bookingTime": "10:00",
    "duration": 120,
    "location": "123 Test St",
    "totalAmount": 100.00
  }' || echo "Booking test failed"

echo "Local testing completed!"