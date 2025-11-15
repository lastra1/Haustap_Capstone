const express = require('express');
const router = express.Router();

// Health check endpoint
router.get('/health', (req, res) => {
  res.json({ status: 'OK', service: 'users' });
});

// Basic user endpoints (mock implementation)
router.get('/', (req, res) => {
  // Mock users list
  const users = [
    {
      id: 1,
      name: 'John Doe',
      email: 'john@example.com',
      role: 'customer'
    },
    {
      id: 2,
      name: 'Jane Smith',
      email: 'jane@example.com',
      role: 'service_provider'
    }
  ];
  
  res.json(users);
});

router.get('/:id', (req, res) => {
  const { id } = req.params;
  
  // Mock single user
  res.json({
    id: parseInt(id),
    name: 'John Doe',
    email: 'john@example.com',
    role: 'customer',
    phone: '555-1234',
    address: '123 Main St'
  });
});

router.put('/:id', (req, res) => {
  const { id } = req.params;
  const { name, email, phone, address } = req.body;
  
  // Mock user update
  res.json({
    message: 'User updated successfully',
    user: {
      id: parseInt(id),
      name: name || 'John Doe',
      email: email || 'john@example.com',
      phone: phone || '555-1234',
      address: address || '123 Main St'
    }
  });
});

module.exports = router;