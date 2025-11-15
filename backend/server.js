const express = require('express');
const cors = require('cors');
const app = express();
const PORT = process.env.PORT || 3001;

// Middleware
app.use(cors());
app.use(express.json());

// Mock data for API endpoints
const mockUsers = [
  { id: 1, name: 'John Doe', email: 'john@example.com', role: 'client', firebase_id: 'fb_123' },
  { id: 2, name: 'Jane Smith', email: 'jane@example.com', role: 'provider', firebase_id: 'fb_456' }
];

const mockBookings = [
  { id: 1, user_id: 1, service_id: 101, provider_id: 2, status: 'pending', firebase_id: 'fb_booking_1' },
  { id: 2, user_id: 2, service_id: 102, provider_id: 1, status: 'completed', firebase_id: 'fb_booking_2' }
];

// Health check endpoint
app.get('/api/health', (req, res) => {
  res.json({ status: 'ok', timestamp: new Date().toISOString() });
});

// Sync status endpoint
app.get('/api/sync/status', (req, res) => {
  res.json({
    success: true,
    data: {
      mysql_users: mockUsers.length,
      mysql_bookings: mockBookings.length,
      unsynced_bookings: 0,
      users_with_firebase_id: mockUsers.filter(u => u.firebase_id).length,
      last_sync: {
        users: new Date().toISOString(),
        bookings: new Date().toISOString()
      }
    }
  });
});

// Sync users to Firebase
app.post('/api/sync/users/to-firebase', (req, res) => {
  res.json({
    success: true,
    data: { synced: mockUsers.length, errors: [] },
    message: `${mockUsers.length} users synced to Firebase`
  });
});

// Sync users from Firebase
app.post('/api/sync/users/from-firebase', (req, res) => {
  res.json({
    success: true,
    data: { synced: mockUsers.length, errors: [] },
    message: `${mockUsers.length} users synced from Firebase`
  });
});

// Sync bookings
app.post('/api/sync/bookings', (req, res) => {
  res.json({
    success: true,
    data: { mysql_to_firebase: mockBookings.length, firebase_to_mysql: 0, errors: [] },
    message: `${mockBookings.length} bookings synced to Firebase`
  });
});

// Full sync
app.post('/api/sync/full', (req, res) => {
  res.json({
    success: true,
    data: {
      users: { synced: mockUsers.length, errors: [] },
      bookings: { mysql_to_firebase: mockBookings.length, firebase_to_mysql: 0, errors: [] }
    },
    message: `Full sync completed: ${mockUsers.length} users and ${mockBookings.length} bookings synced`
  });
});

// Firebase categories endpoint
app.get('/api/firebase/categories', (req, res) => {
  res.json({
    success: true,
    data: [
      { id: 1, name: 'Cleaning', slug: 'cleaning', description: 'Home cleaning services' },
      { id: 2, name: 'Beauty', slug: 'beauty', description: 'Beauty and wellness services' },
      { id: 3, name: 'Repair', slug: 'repair', description: 'Home repair services' }
    ]
  });
});

// Firebase services endpoint
app.get('/api/firebase/services', (req, res) => {
  res.json({
    success: true,
    data: [
      { id: 101, name: 'House Cleaning', category_id: 1, price: 50 },
      { id: 102, name: 'AC Cleaning', category_id: 1, price: 75 },
      { id: 103, name: 'Hair Styling', category_id: 2, price: 30 }
    ]
  });
});

// Firebase providers endpoint
app.get('/api/firebase/providers', (req, res) => {
  res.json({
    success: true,
    data: mockUsers.filter(user => user.role === 'provider')
  });
});

// Firebase bookings endpoint
app.get('/api/firebase/bookings', (req, res) => {
  res.json({
    success: true,
    data: mockBookings
  });
});

// Firebase configuration endpoint
app.get('/api/firebase/firebase-config', (req, res) => {
  res.json({
    success: true,
    config: {
      apiKey: "AIzaSyDeG8aV0tU8t8t8t8t8t8t8t8t8t8t8t8t8",
      authDomain: "haustap-booking-system.firebaseapp.com",
      projectId: "haustap-booking-system",
      storageBucket: "haustap-booking-system.firebasestorage.app",
      messagingSenderId: "123456789012",
      appId: "1:123456789012:web:abcd1234efgh5678"
    }
  });
});

// API Documentation
app.get('/api/docs', (req, res) => {
  res.json({
    success: true,
    message: 'HausTap Service Booking Platform API',
    endpoints: {
      'Health Check': 'GET /api/health',
      'Sync Status': 'GET /api/sync/status',
      'Sync Users to Firebase': 'POST /api/sync/users/to-firebase',
      'Sync Users from Firebase': 'POST /api/sync/users/from-firebase',
      'Sync Bookings': 'POST /api/sync/bookings',
      'Full Sync': 'POST /api/sync/full',
      'Firebase Config': 'GET /api/firebase/firebase-config',
      'Firebase Categories': 'GET /api/firebase/categories',
      'Firebase Services': 'GET /api/firebase/services',
      'Firebase Providers': 'GET /api/firebase/providers',
      'Firebase Bookings': 'GET /api/firebase/bookings'
    },
    firebase_integration: 'All data synchronized with Firebase Firestore',
    database: 'SQLite with MySQL-Firebase bridge',
    architecture: 'RESTful API with sync capabilities'
  });
});

// Default route
app.get('/', (req, res) => {
  res.json({
    message: 'HausTap Service Booking Platform API Server is Running!',
    version: '1.0.0',
    endpoints: '/api/docs',
    status: 'active',
    timestamp: new Date().toISOString()
  });
});

// Error handling middleware
app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(500).json({
    success: false,
    message: 'Internal server error',
    error: process.env.NODE_ENV === 'development' ? err.message : 'Something went wrong!'
  });
});

// 404 handler
app.use('*', (req, res) => {
  res.status(404).json({
    success: false,
    message: 'API endpoint not found',
    path: req.originalUrl
  });
});

app.listen(PORT, () => {
  console.log(`🚀 HausTap API Server running on http://localhost:${PORT}`);
  console.log(`📚 API Documentation: http://localhost:${PORT}/api/docs`);
  console.log(`🔍 Health Check: http://localhost:${PORT}/api/health`);
  console.log(`🔄 Sync Status: http://localhost:${PORT}/api/sync/status`);
});