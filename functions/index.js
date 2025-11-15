const functions = require('firebase-functions');
const express = require('express');
const cors = require('cors');
const mysql = require('mysql2/promise');

const app = express();

// Enable CORS for all routes
app.use(cors({
  origin: true,
  credentials: true
}));

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Database configuration
const dbConfig = {
  host: functions.config().mysql?.host || 'localhost',
  port: functions.config().mysql?.port || 3307,
  user: functions.config().mysql?.user || 'haustap_user',
  password: functions.config().mysql?.password || 'haustap_password',
  database: functions.config().mysql?.database || 'haustap_db',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
};

// Create connection pool
const pool = mysql.createPool(dbConfig);

// Health check endpoint
app.get('/api/health', (req, res) => {
  res.json({ 
    status: 'OK', 
    service: 'HausTap API',
    timestamp: new Date().toISOString(),
    database: 'MySQL Connected'
  });
});

// Test database connection
app.get('/api/test-db', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT COUNT(*) as table_count FROM information_schema.tables WHERE table_schema = ?', [dbConfig.database]);
    res.json({
      status: 'Database Connected',
      tables: rows[0].table_count,
      config: {
        host: dbConfig.host,
        database: dbConfig.database,
        port: dbConfig.port
      }
    });
  } catch (error) {
    res.status(500).json({
      status: 'Database Connection Failed',
      error: error.message,
      config: {
        host: dbConfig.host,
        database: dbConfig.database,
        port: dbConfig.port
      }
    });
  }
});

// API Routes - Proxy your existing Laravel endpoints
app.get('/api/services', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM services LIMIT 10');
    res.json({
      success: true,
      data: rows,
      message: 'Services retrieved successfully'
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: 'Failed to retrieve services',
      error: error.message
    });
  }
});

app.get('/api/users', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT id, name, email, created_at FROM users LIMIT 10');
    res.json({
      success: true,
      data: rows,
      message: 'Users retrieved successfully'
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: 'Failed to retrieve users',
      error: error.message
    });
  }
});

app.get('/api/bookings', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM bookings LIMIT 10');
    res.json({
      success: true,
      data: rows,
      message: 'Bookings retrieved successfully'
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: 'Failed to retrieve bookings',
      error: error.message
    });
  }
});

// Catch-all for other API routes
app.all('/api/*', (req, res) => {
  res.json({
    message: 'HausTap API is running!',
    endpoint: req.path,
    method: req.method,
    timestamp: new Date().toISOString(),
    availableEndpoints: [
      'GET /api/health',
      'GET /api/test-db',
      'GET /api/services',
      'GET /api/users',
      'GET /api/bookings'
    ]
  });
});

// Root endpoint
app.get('/', (req, res) => {
  res.json({
    message: 'HausTap API Server is Running!',
    version: '1.0.0',
    timestamp: new Date().toISOString(),
    database: 'MySQL',
    deployment: 'Firebase Functions',
    endpoints: [
      'GET /api/health',
      'GET /api/test-db',
      'GET /api/services',
      'GET /api/users',
      'GET /api/bookings'
    ]
  });
});

// Export the Express app as a Firebase Function
exports.api = functions
  .region('us-central1')
  .runWith({
    memory: '512MB',
    timeoutSeconds: 60,
    minInstances: 0,
    maxInstances: 10
  })
  .https.onRequest(app);