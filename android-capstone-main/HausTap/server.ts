import cors from 'cors';
import dotenv from 'dotenv';
import express from 'express';
import { createServer } from 'http';
import { Server } from 'socket.io';
import { sendOtpEmail } from './src/services';

// Load environment variables before anything else
dotenv.config();

// Verify required environment variables
if (!process.env.GMAIL_USER || !process.env.GMAIL_APP_PASSWORD) {
    console.error('Missing required environment variables: GMAIL_USER and/or GMAIL_APP_PASSWORD');
    process.exit(1);
}

const app = express();

// Middleware
app.use(cors({
  origin: '*', // Allow all origins in development
  credentials: true,
  methods: ['GET', 'POST'],
  allowedHeaders: ['Content-Type', 'Accept'],
}));
app.use(express.json());

// Error handling middleware
app.use((err: any, req: any, res: any, next: any) => {
  console.error('Error:', err);
  res.status(500).json({ 
    success: false, 
    message: 'Server error',
    error: process.env.NODE_ENV === 'development' ? err.message : undefined
  });
});

const PORT = process.env.PORT || 3000;

// Create HTTP server and attach Socket.IO
const httpServer = createServer(app);
const io = new Server(httpServer, {
  cors: {
    origin: '*',
    credentials: true,
    methods: ['GET', 'POST']
  }
});

// In-memory chat store for development (per booking room)
type ChatMessage = { text: string; sender: 'client' | 'provider'; sender_id?: number | null; ts: number };
const roomMessages: Record<string, ChatMessage[]> = {};

function roomKey(bookingId: number | string) {
  return `booking:${bookingId}`;
}

function userRoom(userId: number | string) {
  return `user:${userId}`;
}

function roleRoom(role: 'client' | 'provider' | string) {
  return `role:${String(role).toLowerCase()}`;
}

io.on('connection', (socket) => {
  // Client joins a booking conversation room
  socket.on('booking:join', (payload: { booking_id: number | string; role?: 'client' | 'provider'; user_id?: number }) => {
    const bookingId = payload?.booking_id;
    if (!bookingId) return;
    const room = roomKey(bookingId);
    socket.join(room);

    // Send existing history (last 50 messages)
    const history = roomMessages[room] || [];
    const last50 = history.slice(Math.max(0, history.length - 50));
    socket.emit('booking:history', { booking_id: bookingId, messages: last50 });
  });

  // Incoming message -> broadcast to room and persist
  socket.on('booking:message', (payload: { booking_id: number | string; text: string; sender: 'client' | 'provider'; sender_id?: number | null }) => {
    const bookingId = payload?.booking_id;
    const text = (payload?.text || '').trim();
    const sender = payload?.sender || 'client';
    const sender_id = payload?.sender_id ?? null;
    if (!bookingId || !text) return;

    const room = roomKey(bookingId);
    const msg: ChatMessage = { text, sender, sender_id, ts: Date.now() };
    if (!roomMessages[room]) roomMessages[room] = [];
    roomMessages[room].push(msg);

    io.to(room).emit('booking:message:new', { booking_id: bookingId, message: msg });
  });

  // Typing indicator
  socket.on('booking:typing', (payload: { booking_id: number | string; role?: 'client' | 'provider' }) => {
    const bookingId = payload?.booking_id;
    if (!bookingId) return;
    const room = roomKey(bookingId);
    socket.to(room).emit('booking:typing', payload);
  });

  // User-specific room join for notifications
  socket.on('user:join', (payload: { user_id: number | string }) => {
    const userId = payload?.user_id;
    if (!userId) return;
    socket.join(userRoom(userId));
  });

  // Role-wide room join for broadcast notifications
  socket.on('role:join', (payload: { role: 'client' | 'provider' | string }) => {
    const role = (payload?.role || '').toString().toLowerCase();
    if (!role) return;
    socket.join(roleRoom(role));
  });
});

app.post('/api/send-otp', async (req, res) => {
    try {
        const { email, otp } = req.body;
        const sent = await sendOtpEmail(email, otp);
        
        if (sent) {
            res.json({ success: true });
        } else {
            res.status(500).json({ success: false, message: 'Failed to send email' });
        }
    } catch (error) {
        console.error('Error in send-otp endpoint:', error);
        res.status(500).json({ success: false, message: 'Server error' });
    }
});

// Generic notification endpoint for backend triggers
app.post('/notify', (req, res) => {
  try {
    const {
      type,
      title,
      body,
      icon,
      data,
      booking_id,
      to_user_id,
      to_role,
    } = req.body || {};

    const payload = {
      type: type || 'notification',
      title: title || '',
      body: body || '',
      icon: icon || '',
      data: data || {},
      booking_id: booking_id ?? null,
      to_user_id: to_user_id ?? null,
      to_role: (to_role || '').toString().toLowerCase() || null,
      ts: Date.now(),
    };

    let delivered = false;
    if (payload.booking_id != null) {
      io.to(roomKey(payload.booking_id)).emit('notify', payload);
      delivered = true;
    }
    if (payload.to_user_id != null) {
      io.to(userRoom(payload.to_user_id)).emit('notify', payload);
      delivered = true;
    }
    if (payload.to_role) {
      io.to(roleRoom(payload.to_role)).emit('notify', payload);
      delivered = true;
    }
    // Fallback broadcast if no specific target
    if (!delivered) {
      io.emit('notify', payload);
    }

    res.json({ success: true });
  } catch (e: any) {
    console.error('Notify endpoint error:', e?.message || e);
    res.status(500).json({ success: false, message: 'Server error' });
  }
});

httpServer.listen(Number(PORT), '0.0.0.0', () => {
  console.log(`Server running on http://0.0.0.0:${PORT}`);
  console.log(`Email configured for: ${process.env.GMAIL_USER}`);
  console.log('Socket.IO enabled for booking chats');
  console.log('Notification gateway available at POST /notify');
});
