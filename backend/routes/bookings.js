const express = require('express');
const router = express.Router();

// Health check endpoint
router.get('/health', (req, res) => {
  res.json({ status: 'OK', service: 'bookings' });
});

// Basic booking endpoints (mock implementation)
router.get('/', (req, res) => {
  // Mock bookings list
  const bookings = [
    {
      id: 1,
      service: 'House Cleaning',
      date: '2025-11-20',
      time: '10:00 AM',
      status: 'confirmed',
      customer: 'John Doe'
    },
    {
      id: 2,
      service: 'Plumbing',
      date: '2025-11-21',
      time: '2:00 PM',
      status: 'pending',
      customer: 'Jane Smith'
    }
  ];
  
  res.json(bookings);
});

router.post('/', (req, res) => {
  const { service, date, time, customer } = req.body;
  
  if (!service || !date || !time || !customer) {
    return res.status(400).json({ error: 'All fields are required' });
  }
  
  // Mock booking creation
  res.json({
    message: 'Booking created successfully',
    booking: {
      id: Math.floor(Math.random() * 1000),
      service,
      date,
      time,
      status: 'pending',
      customer
    }
  });
});

router.get('/:id', (req, res) => {
  const { id } = req.params;
  
  // Mock single booking
  res.json({
    id: parseInt(id),
    service: 'House Cleaning',
    date: '2025-11-20',
    time: '10:00 AM',
    status: 'confirmed',
    customer: 'John Doe',
    address: '123 Main St',
    phone: '555-1234'
  });
});

module.exports = router;