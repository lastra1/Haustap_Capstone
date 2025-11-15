# HausTap Docker Setup

## 🚀 Quick Start

### Prerequisites
- Docker & Docker Compose installed
- Firebase Service Account JSON file

### 1. Setup Firebase Service Account
1. Go to Firebase Console → Project Settings → Service Accounts
2. Click "Generate new private key"
3. Save the JSON file as `storage/app/firebase/service-account.json`

### 2. Environment Configuration
```bash
cp .env.docker .env
```

Edit `.env` file with your specific configurations.

### 3. Build and Start Services
```bash
docker-compose up -d --build
```

### 4. Access Services
- **Laravel Backend**: http://localhost:8001
- **PHPMyAdmin**: http://localhost:8081
- **MySQL Database**: localhost:3306
- **Redis Cache**: localhost:6379
- **Socket Server**: localhost:3000

## 📋 Services Overview

| Service | Port | Description |
|---------|------|-------------|
| Laravel Backend | 8001 | Main API server |
| MySQL Database | 3306 | Primary database |
| Redis Cache | 6379 | Session & cache storage |
| PHPMyAdmin | 8081 | Database management |
| Socket Server | 3000 | Real-time notifications |
| Nginx | 80/443 | Web server |

## 🔧 Configuration

### Database Configuration
- **Database**: `haustap_db`
- **Username**: `haustap_user`
- **Password**: `haustap_password`
- **Root Password**: `root_password`

### Firebase Integration
- Project ID: `haustap-booking-system`
- Service Account: `storage/app/firebase/service-account.json`

## 🛠️ Commands

### Start Services
```bash
docker-compose up -d
```

### Stop Services
```bash
docker-compose down
```

### View Logs
```bash
docker-compose logs -f [service_name]
```

### Access Container
```bash
docker-compose exec backend bash
```

### Run Migrations
```bash
docker-compose exec backend php artisan migrate
```

### Clear Caches
```bash
docker-compose exec backend php artisan config:clear
docker-compose exec backend php artisan cache:clear
```

## 🔒 Security

### Environment Variables
- Change default passwords in `.env`
- Set `APP_DEBUG=false` in production
- Use HTTPS in production

### Database Security
- Strong passwords configured
- MySQL configured with security best practices
- Database access restricted to Docker network

### API Security
- Laravel Sanctum for API authentication
- Firebase Admin SDK for secure backend operations
- CORS properly configured

## 📊 API Endpoints

### Authentication
- `POST /api/firebase/users/create` - Create user
- `GET /api/firebase/users/{uid}` - Get user data
- `PUT /api/firebase/users/{uid}/profile` - Update profile

### Bookings
- `POST /api/firebase/bookings/create` - Create booking
- `GET /api/firebase/bookings/{id}` - Get booking
- `GET /api/firebase/users/{uid}/bookings` - User bookings
- `PUT /api/firebase/bookings/{id}/status` - Update status

### Service Providers
- `GET /api/firebase/service-providers/available` - Available providers

### Vouchers
- `GET /api/firebase/vouchers/valid` - Valid vouchers

### Dashboard
- `GET /api/firebase/dashboard/stats` - Statistics

## 🔄 Real-time Features

Socket server provides real-time notifications for:
- Booking status updates
- New bookings
- User status changes
- Voucher usage

Connect to `ws://localhost:3000` with Firebase authentication token.

## 🐛 Troubleshooting

### Common Issues

1. **Service won't start**
   ```bash
   docker-compose down
   docker-compose up -d --build
   ```

2. **Database connection issues**
   ```bash
   docker-compose exec mysql mysql -u haustap_user -p
   ```

3. **Permission issues**
   ```bash
   docker-compose exec backend chown -R www-data:www-data /var/www/storage
   ```

4. **Firebase errors**
   - Check service account file exists
   - Verify Firebase project ID in .env

### Logs
```bash
# All services
docker-compose logs

# Specific service
docker-compose logs backend
docker-compose logs mysql
```

## 📈 Performance

- PHP-FPM with optimized configuration
- Redis for session and cache storage
- Nginx with gzip compression
- MySQL with performance tuning
- Supervisor for process management

## 🚀 Production Deployment

1. Update environment variables for production
2. Set up SSL certificates
3. Configure firewall rules
4. Set up monitoring and logging
5. Configure backup strategies

## 📞 Support

For issues related to:
- Docker setup: Check logs and configuration
- Firebase integration: Verify service account
- Database: Check connection and migrations
- API: Test endpoints with provided tools