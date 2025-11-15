require('dotenv').config();
const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const redis = require('redis');
const cors = require('cors');
const admin = require('firebase-admin');

const app = express();
const server = http.createServer(app);

// CORS configuration
app.use(cors({
  origin: process.env.FRONTEND_URL || 'http://localhost:3000',
  credentials: true
}));

app.use(express.json());

// Redis client setup
const redisClient = redis.createClient({
  host: process.env.REDIS_HOST || 'redis',
  port: process.env.REDIS_PORT || 6379
});

redisClient.on('error', (err) => {
  console.error('Redis Client Error:', err);
});

redisClient.connect();

// Firebase Admin SDK setup
const serviceAccount = require('../storage/app/firebase/service-account.json');

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: `https://${process.env.FIREBASE_PROJECT_ID}.firebaseio.com`
});

// Socket.IO setup
const io = socketIo(server, {
  cors: {
    origin: process.env.FRONTEND_URL || 'http://localhost:3000',
    methods: ['GET', 'POST'],
    credentials: true
  }
});

// Socket authentication middleware
io.use(async (socket, next) => {
  try {
    const token = socket.handshake.auth.token;
    if (!token) {
      return next(new Error('Authentication error: No token provided'));
    }

    const decodedToken = await admin.auth().verifyIdToken(token);
    socket.userId = decodedToken.uid;
    socket.userEmail = decodedToken.email;
    
    console.log(`✅ User authenticated: ${decodedToken.email}`);
    next();
  } catch (error) {
    console.error('❌ Authentication error:', error);
    next(new Error('Authentication error: Invalid token'));
  }
});

// Socket connection handling
io.on('connection', (socket) => {
  console.log(`🔌 User connected: ${socket.userEmail} (${socket.userId})`);

  // Join user-specific room
  socket.join(`user_${socket.userId}`);
  
  // Join role-based rooms
  socket.on('joinRole', (role) => {
    socket.join(`role_${role}`);
    console.log(`👥 User ${socket.userEmail} joined role: ${role}`);
  });

  // Handle booking status updates
  socket.on('bookingStatusUpdate', async (data) => {
    try {
      const { bookingId, status, notes } = data;
      
      // Broadcast to relevant users
      const booking = await getBookingData(bookingId);
      if (booking) {
        const notification = {
          bookingId,
          status,
          notes,
          timestamp: new Date().toISOString(),
          userId: socket.userId
        };

        // Notify client
        socket.to(`user_${booking.clientId}`).emit('bookingNotification', notification);
        
        // Notify service provider
        if (booking.serviceProviderId) {
          socket.to(`user_${booking.serviceProviderId}`).emit('bookingNotification', notification);
        }

        // Notify admin users
        socket.to('role_admin').emit('bookingNotification', notification);

        console.log(`📢 Booking status updated: ${bookingId} -> ${status}`);
      }
    } catch (error) {
      console.error('❌ Error updating booking status:', error);
      socket.emit('error', { message: 'Failed to update booking status' });
    }
  });

  // Handle new booking creation
  socket.on('newBooking', async (data) => {
    try {
      const { bookingId, clientId, serviceProviderId } = data;
      
      const notification = {
        bookingId,
        type: 'new_booking',
        clientId,
        serviceProviderId,
        timestamp: new Date().toISOString(),
        userId: socket.userId
      };

      // Notify service provider
      if (serviceProviderId) {
        socket.to(`user_${serviceProviderId}`).emit('newBookingNotification', notification);
      }

      // Notify admin users
      socket.to('role_admin').emit('newBookingNotification', notification);

      console.log(`📋 New booking created: ${bookingId}`);
    } catch (error) {
      console.error('❌ Error creating new booking:', error);
      socket.emit('error', { message: 'Failed to create booking notification' });
    }
  });

  // Handle user status updates
  socket.on('userStatusUpdate', (data) => {
    try {
      const { userId, status, role } = data;
      
      const notification = {
        userId,
        status, // online, offline, busy
        role,
        timestamp: new Date().toISOString()
      };

      // Broadcast to relevant users based on role
      if (role === 'service_provider') {
        socket.to('role_client').emit('serviceProviderStatusUpdate', notification);
      }

      console.log(`👤 User status updated: ${userId} -> ${status}`);
    } catch (error) {
      console.error('❌ Error updating user status:', error);
      socket.emit('error', { message: 'Failed to update user status' });
    }
  });

  // Handle voucher usage
  socket.on('voucherUsed', (data) => {
    try {
      const { voucherCode, userId, discountAmount } = data;
      
      const notification = {
        voucherCode,
        userId,
        discountAmount,
        timestamp: new Date().toISOString()
      };

      // Notify admin users
      socket.to('role_admin').emit('voucherNotification', notification);

      console.log(`🎫 Voucher used: ${voucherCode} by ${userId}`);
    } catch (error) {
      console.error('❌ Error processing voucher:', error);
      socket.emit('error', { message: 'Failed to process voucher' });
    }
  });

  // Handle disconnection
  socket.on('disconnect', () => {
    console.log(`👋 User disconnected: ${socket.userEmail} (${socket.userId})`);
    
    // Update user status to offline
    const offlineNotification = {
      userId: socket.userId,
      status: 'offline',
      timestamp: new Date().toISOString()
    };
    
    socket.broadcast.emit('serviceProviderStatusUpdate', offlineNotification);
  });

  // Handle errors
  socket.on('error', (error) => {
    console.error('❌ Socket error:', error);
  });
});

// Helper function to get booking data (simulate - replace with actual DB call)
async function getBookingData(bookingId) {
  // This would typically query your database
  // For now, return mock data
  return {
    clientId: 'client123',
    serviceProviderId: 'provider456',
    status: 'pending'
  };
}

// Health check endpoint
app.get('/health', (req, res) => {
  res.json({
    status: 'ok',
    timestamp: new Date().toISOString(),
    service: 'HausTap Socket Server',
    connections: io.engine.clientsCount
  });
});

// Get connected users
app.get('/connections', (req, res) => {
  const rooms = io.sockets.adapter.rooms;
  const connectedUsers = [];
  
  rooms.forEach((sockets, room) => {
    if (room.startsWith('user_')) {
      connectedUsers.push({
        userId: room.replace('user_', ''),
        socketCount: sockets.size
      });
    }
  });
  
  res.json({
    totalConnections: io.engine.clientsCount,
    connectedUsers: connectedUsers
  });
});

const PORT = process.env.PORT || 3000;

server.listen(PORT, '0.0.0.0', () => {
  console.log(`🚀 HausTap Socket Server running on port ${PORT}`);
  console.log(`📡 Redis: ${process.env.REDIS_HOST || 'redis'}:${process.env.REDIS_PORT || 6379}`);
  console.log(`🔥 Firebase: ${process.env.FIREBASE_PROJECT_ID}`);
});

module.exports = { app, server, io };