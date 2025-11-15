const express = require('express');
const router = express.Router();

// Health check endpoint
router.get('/health', (req, res) => {
  res.json({ status: 'OK', service: 'services' });
});

// Basic services endpoints (mock implementation)
router.get('/', (req, res) => {
  // Mock services list
  const services = [
    {
      id: 1,
      name: 'House Cleaning',
      category: 'cleaning',
      price: 50,
      duration: '2 hours'
    },
    {
      id: 2,
      name: 'Plumbing',
      category: 'repair',
      price: 80,
      duration: '1 hour'
    },
    {
      id: 3,
      name: 'Electrical',
      category: 'repair',
      price: 70,
      duration: '1.5 hours'
    }
  ];
  
  res.json(services);
});

router.get('/:id', (req, res) => {
  const { id } = req.params;
  
  // Mock single service
  res.json({
    id: parseInt(id),
    name: 'House Cleaning',
    category: 'cleaning',
    price: 50,
    duration: '2 hours',
    description: 'Professional house cleaning service',
    provider: 'CleanPro Services'
  });
});

module.exports = router;