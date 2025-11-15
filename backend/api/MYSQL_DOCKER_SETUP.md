# MySQL Docker Setup Guide for HausTap Service Booking Platform

## 🚨 Current Issue: Docker Desktop Not Running

Docker Desktop appears to be having connectivity issues. Here are alternative solutions:

## 🔧 Solution 1: Manual Docker Desktop Startup

1. **Start Docker Desktop Manually**
   - Open Docker Desktop application
   - Wait for it to fully start (green indicator)
   - Try the commands again

2. **Check Docker Service Status**
   ```powershell
   # Check if Docker service is running
   Get-Service com.docker.service
   
   # Start Docker service if stopped
   Start-Service com.docker.service
   ```

## 🔧 Solution 2: Local MySQL Installation

If Docker continues to have issues, install MySQL locally:

### **Option A: MySQL Installer (Recommended)**
1. Download MySQL Installer from: https://dev.mysql.com/downloads/installer/
2. Install MySQL Server 8.0
3. Set root password: `root_password`
4. Create database: `haustap_db`

### **Option B: XAMPP/WAMP**
1. Download XAMPP from: https://www.apachefriends.org/
2. Install and start MySQL service
3. Use phpMyAdmin to create database

## 🔧 Solution 3: Alternative Docker Setup

Let me create a simplified Docker setup that might work:

### **Step 1: Create Minimal Docker Compose**
```yaml
# docker-compose-simple.yml
version: '3.8'

services:
  mysql:
    image: mysql:8.0
    container_name: haustap_mysql
    environment:
      MYSQL_DATABASE: haustap_db
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_USER: haustap_user
      MYSQL_PASSWORD: haustap_password
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
    command: --default-authentication-plugin=mysql_native_password

volumes:
  mysql_data:
```

### **Step 2: Start MySQL Container**
```bash
docker-compose -f docker-compose-simple.yml up -d
```

## 📝 Laravel Configuration for MySQL

Once MySQL is running (via Docker or local), update your Laravel `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=haustap_db
DB_USERNAME=haustap_user
DB_PASSWORD=haustap_password
```

For Docker MySQL, use:
```env
DB_HOST=host.docker.internal  # For Windows Docker Desktop
# OR
DB_HOST=localhost             # For local MySQL
```

## 🧪 Testing MySQL Connection

### **Test 1: Laravel Connection**
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### **Test 2: MySQL Command Line**
```bash
mysql -u haustap_user -p haustap_db
```

### **Test 3: phpMyAdmin Access**
- URL: http://localhost:8081
- Username: haustap_user
- Password: haustap_password

## 🚀 Database Migration Commands

Once MySQL is connected:

```bash
# Switch to MySQL database
php artisan db:switch mysql

# Run migrations
php artisan migrate

# Check migration status
php artisan migrate:status
```

## 📊 HausTap Database Schema

Your MySQL will include these tables:
- `users` - User accounts
- `user_roles` - Multi-role system
- `bookings` - Service bookings
- `providers` - Service provider profiles
- `chat_messages` - Communication system
- `otp_codes` - Authentication codes

## 🔍 Troubleshooting

### **Docker Issues**
```bash
# Check Docker logs
docker logs haustap_mysql

# Restart Docker
docker restart haustap_mysql

# Check container status
docker ps -a
```

### **MySQL Connection Issues**
```bash
# Test MySQL connection
telnet localhost 3306

# Check MySQL service (Windows)
Get-Service MySQL80

# Restart MySQL service
Restart-Service MySQL80
```

## 🎯 Next Steps

1. **Choose your preferred MySQL setup method**
2. **Start MySQL service**
3. **Configure Laravel connection**
4. **Run database migrations**
5. **Test the connection**

Would you like me to help you with any specific approach or troubleshoot further?