const functions = require('firebase-functions');
const { onRequest } = require('firebase-functions/v2/https');
const axios = require('axios');

// API Proxy Function for Firebase Hosting
exports.apiProxy = onRequest({
  cors: true,
  region: 'us-central1',
  maxInstances: 100,
}, async (req, res) => {
  try {
    // Your Laravel API URL (replace with your actual API URL)
    const apiUrl = 'https://your-laravel-api-url.com';
    
    // Extract the API path from the request
    const apiPath = req.path.replace('/api', '');
    const targetUrl = `${apiUrl}/api${apiPath}`;
    
    console.log(`Proxying request to: ${targetUrl}`);
    console.log(`Method: ${req.method}`);
    console.log(`Headers:`, req.headers);
    
    // Prepare the request configuration
    const config = {
      method: req.method,
      url: targetUrl,
      headers: {
        'Content-Type': req.headers['content-type'] || 'application/json',
        'Authorization': req.headers.authorization || '',
        'X-Forwarded-For': req.ip,
        'X-Real-IP': req.ip,
      },
      timeout: 30000, // 30 second timeout
    };
    
    // Add request body for POST, PUT, PATCH methods
    if (['POST', 'PUT', 'PATCH'].includes(req.method)) {
      config.data = req.body;
    }
    
    // Add query parameters
    if (Object.keys(req.query).length > 0) {
      config.params = req.query;
    }
    
    // Make the request to your Laravel API
    const response = await axios(config);
    
    // Forward the response
    res.status(response.status).json(response.data);
    
  } catch (error) {
    console.error('API Proxy Error:', error.message);
    
    if (error.response) {
      // Laravel API returned an error
      res.status(error.response.status).json(error.response.data);
    } else if (error.code === 'ECONNREFUSED') {
      res.status(503).json({
        error: 'Service Unavailable',
        message: 'Laravel API is not reachable'
      });
    } else if (error.code === 'ETIMEDOUT') {
      res.status(504).json({
        error: 'Gateway Timeout',
        message: 'Request to Laravel API timed out'
      });
    } else {
      res.status(500).json({
        error: 'Internal Server Error',
        message: 'Failed to proxy request to Laravel API'
      });
    }
  }
});

// Health check function
exports.health = functions.https.onRequest((req, res) => {
  res.json({
    status: 'healthy',
    timestamp: new Date().toISOString(),
    service: 'HausTap API Proxy',
    version: '1.0.0'
  });
});

// CORS configuration for Firebase Functions
exports.corsConfig = {
  origin: [
    'http://localhost:3000',
    'http://localhost:8080',
    'https://haustap-booking-system.web.app',
    'https://haustap-booking-system.firebaseapp.com'
  ],
  methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
  allowedHeaders: ['Content-Type', 'Authorization', 'X-Requested-With'],
  credentials: true,
  maxAge: 86400
};