# MySQL Setup Guide for HausTap Service Booking Platform

## Current Status
Your HausTap Service Booking Platform currently has a multi-database architecture with:
- **Active**: Firestore (currently in use)
- **Ready**: MySQL (configuration ready, needs container)
- **Available**: SQLite (fallback option)

## Docker MySQL Setup (Preferred Method)

### Prerequisites
- Docker Desktop installed and running
- Docker daemon responding properly

### Files Created
1. `docker-compose-mysql-simple.yml` - Simplified MySQL container setup
2. `.env.mysql` - Laravel MySQL environment configuration
3. `setup-mysql-docker.sh` - Automated setup script

### Current Issue
Docker Desktop is experiencing connectivity issues (500 Internal Server Error). This prevents container startup.

### To Fix Docker Issues
1. **Restart Docker Desktop manually**:
   - Find Docker Desktop in Start Menu
   - Right-click and select "Run as administrator"
   - Wait for Docker to fully start (whale icon stops animating)

2. **Alternative Docker restart**:
   ```powershell
   # Stop Docker
   Stop-Process -Name "Docker Desktop" -Force
   # Start Docker
   Start-Process "C:\Program Files\Docker\Docker\Docker Desktop.exe"
   ```

3. **Test Docker connectivity**:
   ```powershell
   docker version
   docker ps
   ```

### Once Docker is Working
```powershell
# Navigate to backend/api directory
cd C:\Users\von\Desktop\Repositories\2025\Haustap_Updated\backend\api

# Start MySQL container
docker-compose -f docker-compose-mysql-simple.yml up -d

# Verify container is running
docker ps

# Check MySQL logs
docker logs haustap_mysql
```

## Local MySQL Installation (Alternative)

### Option 1: MySQL Installer
1. Download MySQL Installer from https://dev.mysql.com/downloads/installer/
2. Run installer and select:
   - MySQL Server 8.0
   - MySQL Workbench (optional)
   - MySQL Shell (optional)

### Option 2: XAMPP/WAMP
1. Download XAMPP from https://www.apachefriends.org/
2. Install with MySQL service
3. Use phpMyAdmin for database management

### Configuration for Local MySQL
Update `.env.mysql` with local connection details:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=haustap_db
DB_USERNAME=root
DB_PASSWORD=your_root_password
```

## Laravel Database Switching

### Switch to MySQL
```powershell
cd C:\Users\von\Desktop\Repositories\2025\Haustap_Updated\backend\api

# Copy MySQL environment
copy .env.mysql .env

# Switch database connection
php artisan db:switch mysql

# Run migrations
php artisan migrate

# Seed database (if needed)
php artisan db:seed
```

### Verify Connection
```powershell
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit;
```

### Switch Back to Firestore
```powershell
php artisan db:switch firestore
```

## Database Schema
Your Service Booking Platform includes these tables:
- `user_roles` - User role definitions
- `user_modes` - User mode settings
- `provider_applications` - Service provider applications
- `provider_statuses` - Provider status tracking
- `providers` - Service provider profiles
- `bookings` - Booking records
- `booking_returns` - Booking return/refund data
- `chat_conversations` - Chat conversation threads
- `chat_messages` - Individual chat messages
- `otp_codes` - One-time password codes
- `system_settings` - Platform configuration

## Troubleshooting

### Docker Issues
1. **500 Internal Server Error**: Docker Desktop connectivity problem
2. **Container won't start**: Check port 3306 availability
3. **Permission denied**: Run PowerShell as Administrator

### MySQL Connection Issues
1. **Access denied**: Check user credentials in .env.mysql
2. **Connection refused**: Verify MySQL service is running
3. **Database not found**: Create database manually or run migrations

### Laravel Issues
1. **Migration fails**: Check database connection and permissions
2. **Class not found**: Run `composer dump-autoload`
3. **Environment not loading**: Clear cache with `php artisan config:clear`

## Next Steps
1. **Fix Docker connectivity** (preferred)
2. **Alternative**: Install MySQL locally
3. **Configure Laravel connection**
4. **Run migrations and test**
5. **Switch between databases as needed**

Your platform is ready for MySQL - we just need to resolve the Docker connectivity issue or set up local MySQL as an alternative.